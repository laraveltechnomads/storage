<?php

namespace App\Utils\Master;
use Illuminate\Http\Request;

Class UniqueUtil
{

    /* reference_details */
    public function reference_details()
    {
        return array(
            [
                'id' => '1',
                'name' => 'None'
            ],
            [
                'id' => '2',
                'name' => 'UserOne'
            ],
            [
                'id' => '3',
                'name' => 'UserTwo'
            ]
        );
    }

    /* referral Doctor */
    public function referral_doctor()
    {
        return array(
            [
                'id' => '1',
                'name' => 'None'
            ],
            [
                'id' => '2',
                'name' => 'One Doctor'
            ],
            [
                'id' => '2',
                'name' => 'Two Doctor'
            ]
        );
    }

    /* nationality */
    public function nationality()
    {
        return array(
            [
                'id' => '1',
                'name' => 'American'
            ],
            [
                'id' => '2',
                'name' => 'Filipino'
            ],
            [
                'id' => '3',
                'name' => 'Indian'
            ],
            [
                'id' => '4',
                'name' => 'NRI'
            ],
            [
                'id' => '5',
                'name' => 'Other'
            ]
        );
    }

    /* Ethnicity */
    public function ethnicity()
    {
        return array(
            [
                'id' => '1',
                'name' => 'None'
            ]
        );
    }

    /* Education */
    public function education()
    {
        return array(
            [
                'id' => '1',
                'name' => 'None'
            ],
            [
                'id' => '2',
                'name' => 'Bsc'
            ],
            [
                'id' => '3',
                'name' => 'Msc'
            ],
            [
                'id' => '4',
                'name' => 'MCS'
            ],
            [
                'id' => '5',
                'name' => 'MCM'
            ],
            [
                'id' => '6',
                'name' => 'MCA'
            ],
            [
                'id' => '7',
                'name' => 'BE'
            ],
            [
                'id' => '8',
                'name' => 'CA'
            ],
            [
                'id' => '9',
                'name' => 'Mcom'
            ],
            [
                'id' => '10',
                'name' => 'Statitics'
            ],
            [
                'id' => '11',
                'name' => 'Bcom'
            ]
        );
    }

    /* Occuption */
    public function occuption()
    {
        return array(
            [
                'id' => 1,
                'occup_code' => 1,
                'name' => 'None'
            ],
            [
                'id' => 2,
                'occup_code' => 2,
                'name' => 'ENGINEERING'
            ],
            [
                'id' => 3,
                'occup_code' => 3,
                'name' => 'HEALTHCARE'
            ],
            [
                'id' => 4,
                'occup_code' => 4,
                'name' => 'PUBLIC SECTOR EMPLOYEE'
            ],
            [
                'id' => 5,
                'occup_code' => 5,
                'name' => 'SELF - EMPLOYED'
            ],
            [
                'id' => 6,
                'occup_code' => 6,
                'name' => 'AGRICULTURE'
            ],
            [
                'id' => 7,
                'occup_code' => 7,
                'name' => 'DEFENCE'
            ],
            [
                'id' => 8,
                'occup_code' => 8,
                'name' => 'TEACHING'
            ],
            [
                'id' => 9,
                'occup_code' => 9,
                'name' => 'CONSULTING'
            ],
            [
                'id' => 10,
                'occup_code' => 10,
                'name' => 'BANKING'
            ],
            [
                'id' => 11,
                'occup_code' => 11,
                'name' => 'FINANCE'
            ],
            [
                'id' => 12,
                'occup_code' => 12,
                'name' => 'ACCOUNTING'
            ],
            [
                'id' => 13,
                'occup_code' => 13,
                'name' => 'LEGAL'
            ],
            [
                'id' => 14,
                'occup_code' => 14,
                'name' => 'HOUSEWIFE'
            ],
            [
                'id' => 15,
                'occup_code' => 15,
                'name' => 'SERVICE'
            ]
        );
    }

    /* married_since */
    public function married_since()
    {
        return array(
            [
                'id' => '1',
                'name' => '1990'
            ],
            [
                'id' => '2',
                'name' => '1991'
            ],
            [
                'id' => '3',
                'name' => '2000'
            ],
            [
                'id' => '4',
                'name' => '2001'
            ],
            [
                'id' => '5',
                'name' => '2002'
            ],
            [
                'id' => '6',
                'name' => '2018'
            ],
            [
                'id' => '7',
                'name' => '2019'
            ],
            [
                'id' => '8',
                'name' => '2020'
            ],
            [
                'id' => '9',
                'name' => '2021'
            ],
            [
                'id' => '10',
                'name' => '2022'
            ]
        );
    }

    /* Existing Children */
    public function existing_children()
    {
        return array(
            [
                'id' => '1',
                'name' => 'One'
            ],
            [
                'id' => '2',
                'name' => 'Two'
            ],
            [
                'id' => '3',
                'name' => 'Three'
            ],
            [
                'id' => '4',
                'name' => 'Four'
            ],
            [
                'id' => '5',
                'name' => 'Five'
            ],
            [
                'id' => '6',
                'name' => 'Six'
            ],
            [
                'id' => '7',
                'name' => 'Seven'
            ],
            [
                'id' => '8',
                'name' => 'Eight'
            ],
            [
                'id' => '9',
                'name' => 'Nine'
            ],
            [
                'id' => '10',
                'name' => 'Ten'
            ],
            [
                'id' => '11',
                'name' => 'None'
            ],
        );
    }

    /* Family */
    public function family()
    {
        return array(
            [
                'id' => '1',
                'name' => 'N/A'
            ],
            [
                'id' => '2',
                'name' => 'Joint'
            ],
            [
                'id' => '3',
                'name' => 'Nuclear'
            ]
        );
    }

    /* company_name  */
    public function company_name()
    {
        return array(
            [
                'id' => '0',
                'name' => 'None'
            ],
            [
                'id' => '1',
                'name' => 'One1'
            ],
            [
                'id' => '1',
                'name' => 'Two2'
            ]
        );
    }

    /* associate company_name  */
    public function associate_company_name()
    {
        return array(
            [
                'id' => '1',
                'name' => 'None'
            ],
            [
                'id' => '2',
                'name' => 'One1'
            ],
            [
                'id' => '3',
                'name' => 'Two2'
            ]
        );
    }

    /*  religion  */
    public function religion()
    {
        return array(
            [
                'id' => '1',
                'name' => 'N/A'
            ],
            [
                'id' => '2',
                'name' => 'CATHOLIC'
            ],
            [
                'id' => '3',
                'name' => 'Christian'
            ],
            [
                'id' => '4',
                'name' => 'HINDU'
            ],
            [
                'id' => '5',
                'name' => 'MUSLIM'
            ],
            [
                'id' => '6',
                'name' => 'SIKH'
            ],
            [
                'id' => '7',
                'name' => 'BUDDHIST'
            ],
            [
                'id' => '8',
                'name' => 'PARSI'
            ],
            [
                'id' => '9',
                'name' => 'JAINISM'
            ],
            [
                'id' => '10',
                'name' => 'ISLAM'
            ]
        );
    }
}