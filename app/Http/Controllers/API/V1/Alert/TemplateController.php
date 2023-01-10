<?php

namespace App\Http\Controllers\API\V1\Alert;

use App\Http\Controllers\Controller;
use App\Models\API\V1\Master\AlertEventType;
use App\Models\API\V1\Master\EmailTemplate;
use App\Models\API\V1\Master\Events;
use App\Models\API\V1\Master\SmsTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /* Template fields store */
    public function index()
    {
        try {
            $alert = AlertEventType::paginate(5);
            return sendDataHelper('Alert event types list view.', $alert, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    public function create()
    {
        return 'create';
    }

    public function store(Request $request)
    { 
        return self::createAndUpdateAlertEvent($request); 
    }

    public function show($id)
    {
        return 'show';
    }

    public function edit($id)
    {
        return 'edit';
    }

    public function update(Request $request, $id)
    { 
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            $alert = AlertEventType::firstOrNew(['id' => $id]);
            $alert->code = $request['code'];
            $alert->description = $request['description'];
            $alert->client_id = auth()->guard('client')->user()->id;
            $alert->save();

            DB::commit();
            if ($alert) {
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
            
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $alert = AlertEventType::where('id', $id)->delete();
            if ($alert == 1) {
                DB::commit();
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details delete! Try again.', [], $code = 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function createAndUpdateAlertEvent($request, $id = NULL)
    {  
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
           
            $alert = AlertEventType::firstOrNew(['id' => $id]);
            $alert->code = $request['code'];
            $alert->description = $request['description'];
            $alert->client_id = auth()->guard('client')->user()->id;
            $alert->save();

            DB::commit();
            if ($alert) {
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
            
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Email and sms fields select events option list*/
    public function notifyFieldPaginationList(Request $request)
    {
        try {
            $alert = Events::paginate(10);
            return sendDataHelper('Events list view pagination.', $alert, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Events store*/
    public function notifyFieldStore(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'code' => 'required',
                'description' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }

            $event_code = Events::where('code', $request['code'])->first();
            if($event_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $event_desc = Events::where('description', $request['description'])->first();
            if($event_desc)
            {
                return sendErrorHelper("Validation error", 'Desciption already taken.',422);
            }

            $event = new Events;
            $event->code = $request['code'];
            $event->description = $request['description'];
            $event->client_id = auth()->guard('client')->user()->id;
            $event->save();
            DB::commit();
            if ($event) {
                return sendDataHelper('Event successfully submitted.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Events update*/
    public function notifyFieldUpdate(Request $request)
    {   
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'event_id' => 'required',
                'code' => 'required',
                'description' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $event_code = Events::whereNotIn('id',  [$request['event_id']])->where('code', $request['code'])->first();
            if($event_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $event_desc = Events::whereNotIn('id',  [$request['event_id']])->where('description', $request['description'])->first();
            if($event_desc)
            {
                return sendErrorHelper("Validation error", 'Desciption already taken.',422);
            }
            
            $event = Events::find($request['event_id']);
            $event->code = $request['code'];
            $event->description = $request['description'];
            $event->client_id = auth()->guard('client')->user()->id;
            $event->status = @$request['status'] ? true : false;
            $event->update();
            DB::commit();
            if ($event) {
                return sendDataHelper('Event successfully updated.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Selected event show */
    public function notifyFieldSingleList(Request $request)
    {   
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'event_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $event = Events::where('id',  [$request['event_id']])->first();
            if ($event) {
                $response = [
                    'event_id' => $event->id,
                    'event_code' => $event->code,
                    'event_description' => $event->description
                ];
                return sendDataHelper('Event list view', $response, $code = 200);
            } else {
                return sendError('Record not found.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Field delete */
    public function notifyFieldDelete(Request $request)
    {   
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'event_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            // return $request;
            $event = Events::where('id', $request['event_id'])->forceDelete();
            if ($event == 1) {
                DB::commit();
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details delete! Try again.', [], $code = 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }


    /* Emails template pagination list */
    public function emailsPaginationList(Request $request)
    {
        try {
            $email = EmailTemplate::paginate(5);
            return sendDataHelper('Emails list view pagination.', $email, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* Email template store*/
    public function emailTempStore(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $data = Validator::make((array)$request,[
                'code' => 'required',
                'template_name' => 'required',
                'subject' => 'required',
                'field_id' => 'required|numeric',
                'text' => 'required'
            ]);

            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $email_temp_code = EmailTemplate::where('field_id', $request['field_id'])->where('code', $request['code'])->first();
            if($email_temp_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $email_temp_name = EmailTemplate::where('field_id', $request['field_id'])->where('template_name', $request['template_name'])->first();
            if($email_temp_name)
            {
                return sendErrorHelper("Validation error", 'Template name already taken.',422);
            }

            $email_temp = new EmailTemplate;
            $email_temp->code = $request['code'];
            $email_temp->template_name = $request['template_name'];
            $email_temp->subject = $request['subject'];
            $email_temp->text = $request['text'];
            $email_temp->field_id = $request['field_id'];
            $email_temp->client_id = auth()->guard('client')->user()->id;

            $email_temp->save();

            if ($email_temp)
            {
                DB::commit();
                return sendDataHelper('Email template detail successfully submitted.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Email template update*/
    public function emailTempUpdate(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $data = Validator::make((array)$request,[
                'email_temp_id' => 'required',
                'code' => 'required',
                'template_name' => 'required',
                'subject' => 'required',
                'field_id' => 'required|numeric',
                'text' => 'required'
            ]);

            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $email_temp_code = EmailTemplate::where('field_id', $request['field_id'])->where('code', $request['code'])->first();
            if($email_temp_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $email_temp_name = EmailTemplate::where('field_id', $request['field_id'])->where('template_name', $request['template_name'])->first();
            if($email_temp_name)
            {
                return sendErrorHelper("Validation error", 'Template name already taken.',422);
            }

            $email_temp = EmailTemplate::find(@$request['email_temp_id']);
            if($email_temp){
                $email_temp->code = $request['code'];
                $email_temp->template_name = $request['template_name'];
                $email_temp->subject = $request['subject'];
                $email_temp->text = $request['text'];
                $email_temp->field_id = $request['field_id'];
                $email_temp->client_id = auth()->guard('client')->user()->id;

                $email_temp->save();
                if ($email_temp)
                {
                    DB::commit();
                    return sendDataHelper('Email template detail successfully updated.', [], $code = 200);
                }else {
                    return sendError('Failed to details save! Try again.', [], $code = 404);
                }
            }else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }


    /* Selected email show */
    public function emailTempView(Request $request)
    {   
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'email_temp_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $email = EmailTemplate::where('id',  [$request['email_temp_id']])->first();
            if ($email) {
                $response = [
                    'email__temp_id' => $email->id,
                    'email_code' => $email->code,
                    'email_template_name' => $email->template_name,
                    'email_subject' => $email->subject,
                    'email_text' => $email->text,
                    'email_field_id' => $email->field_id,
                    'email_client_id' => $email->client_id
                ];
                return sendDataHelper('Email template view', $response, $code = 200);
            } else {
                return sendError('Record not found.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Email template delete */
    public function emailTempDelete(Request $request)
    {   
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'email_temp_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            // return $request;
            $event = EmailTemplate::where('id', $request['email_temp_id'])->forceDelete();
            if ($event == 1) {
                DB::commit();
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details delete! Try again.', [], $code = 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /* Email and sms fields select events option list*/
    public function smsPaginationList(Request $request)
    {
        try {
            $sms = SmsTemplate::paginate(10);
            return sendDataHelper('SMS template list view pagination.', $sms, $code = 200);
        } catch (\Throwable $th) {
            $bug = $th->getMessage();
            return sendErrorHelper('Error', $bug, 400);
        }
    }

    /* SMS Template store*/
    public function smsTempStore(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            
            $data = Validator::make((array)$request,[
                'code' => 'required',
                'template_name' => 'required',
                'field_id' => 'required|numeric',
                'text' => 'required'
            ]);

            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $sms_temp_code = SmsTemplate::where('field_id', $request['field_id'])->where('code', $request['code'])->first();
            if($sms_temp_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $sms_temp_name = SmsTemplate::where('field_id', $request['field_id'])->where('template_name', $request['template_name'])->first();
            if($sms_temp_name)
            {
                return sendErrorHelper("Validation error", 'Template name already taken.',422);
            }
            $sms_temp = new SmsTemplate;
            $sms_temp->code = $request['code'];
            $sms_temp->template_name = $request['template_name'];
            $sms_temp->text = $request['text'];
            // $sms_temp->field_id = $request['field_id'];
            $sms_temp->save();
            if ($sms_temp)
            {
                DB::commit();
                return sendDataHelper('SMS tempalte details successfully submitted.', [], $code = 200);
            } else {
                return sendError('Failed to details save! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* SMS Template store*/
    public function smsTempUpdate(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/
            
            $data = Validator::make((array)$request,[
                'sms_temp_id' => 'required',
                'code' => 'required',
                'template_name' => 'required',
                'subject' => 'required',
                'field_id' => 'required|numeric',
                'text' => 'required'
            ]);

            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $sms_temp_code = SmsTemplate::where('field_id', $request['field_id'])->where('code', $request['code'])->first();
            if($sms_temp_code)
            {
                return sendErrorHelper("Validation error", 'Code already taken.',422);
            }
            $sms_temp_name = SmsTemplate::where('field_id', $request['field_id'])->where('template_name', $request['template_name'])->first();
            if($sms_temp_name)
            {
                return sendErrorHelper("Validation error", 'Template name already taken.',422);
            }

            $sms_temp = SmsTemplate::find(@$request['sms_temp_id']);
            if ($sms_temp)
            {
                $sms_temp->code = $request['code'];
                $sms_temp->template_name = $request['template_name'];
                $sms_temp->subject = $request['subject'];
                $sms_temp->text = $request['text'];
                $sms_temp->field_id = $request['field_id'];
                $sms_temp->client_id = auth()->guard('client')->user()->id;
                $sms_temp->update();
                if ($sms_temp === 1)
                {
                    DB::commit();
                    return sendDataHelper('SMS tempalte details successfully submitted.', [], $code = 200);
                } else {
                    return sendError('Failed to details update! Try again.', [], $code = 404);
                }
            } else {
                return sendError('Failed to details update! Try again.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* Selected sms template show */
    public function smsTempList(Request $request)
    {   
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'sms_temp_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            
            $email = EmailTemplate::where('id',  [$request['sms_temp_id']])->first();
            if ($email) {
                $response = [
                    'sms_temp_id' => $email->id,
                    'sms_code' => $email->code,
                    'sms_template_name' => $email->template_name,
                    'sms_subject' => $email->subject,
                    'sms_text' => $email->text,
                    'sms_field_id' => $email->field_id,
                    'sms_client_id' => $email->client_id
                ];
                return sendDataHelper('SMS template view', $response, $code = 200);
            } else {
                return sendError('Record not found.', [], $code = 404);
            }
        } catch (\Throwable $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }     
    }

    /* SMS template delete */
    public function smsTempDelete(Request $request)
    {   
        DB::beginTransaction();
        try
        {
            if(respValid($request)) { return respValid($request); }  /* response required validation */           
            $request = decryptData($request['response']); /* Dectrypt  **/

            $data = Validator::make((array)$request,[
                'sms_temp_id' => 'required'
            ]);
            if($data->fails()){
                return sendErrorHelper("Validation error", $data->errors()->first(),422);
            }
            // return $request;
            $sms = SmsTemplate::where('id', $request['sms_temp_id'])->forceDelete();
            if ($sms == 1) {
                DB::commit();
                return sendDataHelper('success.', [], $code = 200);
            } else {
                return sendError('Failed to details delete! Try again.', [], $code = 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $bug = $th->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}