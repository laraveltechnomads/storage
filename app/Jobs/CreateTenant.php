<?php

namespace App\Jobs;

use App\Models\API\V1\Master\Unit;
use App\Models\Client\Client;
use App\Models\Client\ClientCredentialCron;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $find_pending_db = ClientCredentialCron::where('status', 0)->get();
        foreach ($find_pending_db as $dbs) {
            $url_base = config('app.url_base');
            $subdomain = $dbs->sub_domain;
            $name = $dbs->client_fname . ' ' . $dbs->client_name;
            $email = $dbs->email_address;
            // $fqdn = "{$subdomain}.{$url_base}";
            $fqdn = "{$subdomain}";

            // first check to make sure the tenant doesn't already exist
            if ( $this->tenantExists( $fqdn ) ) {
                return sendError("A tenant with the subdomain '{$subdomain}' already exists.", [],422);
            }
            // if the tenant doesn't exist, we'll use the Tenancy package commands to create one
            $hostname = $this->createTenant( $fqdn, $dbs->db_name );

            // swap the environment over to the hostname
            app( Environment::class )->hostname( $hostname );

            // create a new user
            $json = json_decode($dbs->client_json);
            $input['fname'] = $dbs->client_fname;
            $input['lname'] = $dbs->client_lname;
            $input['email_address'] = $email;
            $input['sub_domain'] = $dbs->sub_domain;
            $input['db_name'] = $dbs->db_name;
            $input['password'] = $json->password;
            $input['clinic'] = $json->clinic;
            $input['contact_no'] = $json->contact_no;
            $input['type'] = $json->type;
            $input['identity'] = $json->identity;
            $input['bussiness'] = $json->bussiness;
            $input['terms'] = $json->terms;
            $input['plan_status'] = $json->plan_status;
            $input['status'] = $json->status;
            $input['remember_token'] = $json->remember_token;
            $clientId = Client::create($input);
            $input['created_at'] = now();
            $input['updated_at'] = now();
            DB::connection('system')->table('clients')->insert($input);
            $findUnit = DB::connection('system')->table('units')->where(['c_id' => $dbs->client_id])->get();
            foreach($findUnit as $unit) {
                $unit->c_id = $clientId->id;
                Unit::create((array)$unit);
            }

            // return a success message to the console
            ClientCredentialCron::where('sub_domain', $dbs->sub_domain)->update(['status' => 1]);
            sendDataHelper("Tenant '{$name}' created for {$fqdn}, The user '{$email}' can log in with password {$json->password}", [], 200);
            
        }
    }

    public function tenantExists( $fqdn ) 
    {
        // check to see if any Hostnames in the database have the same fqdn
        return Hostname::where( 'fqdn', $fqdn )->exists();
    }

    public function createTenant( $fqdn, $db_name )
    {
        // first create the 'website'
        $website = new Website;
        // $website->uuid = $db_name;
        $web = app( WebsiteRepository::class )->create( $website );

        // now associate the 'website' with a hostname
        $hostname = new Hostname;
        $hostname->fqdn = $fqdn;
        app( HostnameRepository::class )->attach( $hostname, $website );

        return $hostname;
    }

}
