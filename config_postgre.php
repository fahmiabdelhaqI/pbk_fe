<?php
    $myPDO = new PDO('pgsql:host=192.168.10.173;dbname=pefindo', 'pefindo', 'pefindo123');

    function getParamsLengkapTelco($paramTelco)
    {
        $telcoLengkap = "";
        if($paramTelco == "Int'l Plan" or $paramTelco == "intlPlan" or $paramTelco == "Int_l_Plan_no")
        {
            $telcoLengkap = "International Plan";
        }
        else if($paramTelco == "VMail Message" or $paramTelco == "vMailMessage" or $paramTelco == "VMail_Message" )
        {
            $telcoLengkap = "Voice Mail Message";
        }
        else if($paramTelco == "Day Mins" or $paramTelco == "dayMins" or $paramTelco == "Day_Mins")
        {
            $telcoLengkap = "Day Minutes";
        }
        else if($paramTelco == "Day Calls" or $paramTelco == "dayCalls" or $paramTelco == "Day_Calls")
        {
            $telcoLengkap = "Day Calls";
        }
        else if($paramTelco == "Eve Mins" or $paramTelco == "eveMins" or $paramTelco == "Eve_Mins")
        {
            $telcoLengkap = "Evening Minutes";
        }
        else if($paramTelco == "Eve Calls" or $paramTelco == "eveCalls" or $paramTelco == "Eve_Calls")
        {
            $telcoLengkap = "Evening Calls";
        }
        else if($paramTelco == "Night Mins" or $paramTelco == "nightMins" or $paramTelco == "Night_Mins")
        {
            $telcoLengkap = "Night Minutes";
        }
        else if($paramTelco == "Intl Mins" or $paramTelco == "intlMins" or $paramTelco == "Intl_Mins")
        {
            $telcoLengkap = "International Minutes";
        }
        else if($paramTelco == "Intl Calls" or $paramTelco == "intlCalls" or $paramTelco == "Intl_Calls")
        {
            $telcoLengkap = "International Calls";
        }
        else if($paramTelco == "CustServ Calls" or $paramTelco == "custServCalls" or $paramTelco == "CustServ_Calls")
        {
            $telcoLengkap = "Customer Service Calls";
        }
        else if($paramTelco == "total_call_per_day")
        {
            $telcoLengkap = "Total Calls per Day";
        }
        else if($paramTelco == "total_charge_per_day")
        {
            $telcoLengkap = "Total Charge per Day";
        }
        else if($paramTelco == "eve_charge_per_mins")
        {
            $telcoLengkap = "Evening Charge per Minutes";
        }
        else if($paramTelco == "intl_charge_per_mins")
        {
            $telcoLengkap = "International Charge per Minutes";
        }
        else if($paramTelco == "Int_l_Plan_no")
        {
            $telcoLengkap = "International Plan No.";
        }
        else if($paramTelco == "day_charge_per_mins")
        {
            $telcoLengkap = "Day Charge per Minutes";
        }
        else if($paramTelco == "night_charge_per_mins")
        {
            $telcoLengkap = "Night Charge per Minutes";
        }
        else if($paramTelco == "Night_Calls")
        {
            $telcoLengkap = "Night Calls";
        }

        //Hasil function
        return $telcoLengkap;
    }

    function getParamsLengkapCredit($paramCredit)
    {
        $creditLengkap = "";
        if($paramCredit == "EXT_SOURCE_2")
        {
            $creditLengkap = "External Source 2";
        }
        else if($paramCredit == "count_refused_prev")
        {
            $creditLengkap = "Count Refused Previous";
        }
        else if($paramCredit == "AVG_AMT_ANNUITY_prev")
        {
            $creditLengkap = "Average Amount Annuity Previous";
        }
        else if($paramCredit == "AMT_GOODS_PRICE")
        {
            $creditLengkap = "Amount Goods Price";
        }
        else if($paramCredit == "AVG_DAYS_FIRST_DRAWING")
        {
            $creditLengkap = "Average Days First Drawing";
        }
        else if($paramCredit == "DAYS_ID_PUBLISH")
        {
            $creditLengkap = "Days ID Publish";
        }
        else if($paramCredit == "count_walkin_prod_type_prev")
        {
            $creditLengkap = "Count Walking Production Type Previous";
        }
        else if($paramCredit == "count_approved_prev")
        {
            $creditLengkap = "Count Approved Previous";
        }
        else if($paramCredit == "MAX_DP2GP_RATIO")
        {
            $creditLengkap = "Maximum DP2GP Ratio";
        }
        else if($paramCredit == "AVG_DAYS_ENDDATE_FACT")
        {
            $creditLengkap = "Average Days End Date Fact";
        }
        else if($paramCredit == "EXT_SOURCE_3")
        {
            $creditLengkap = "External Source 3";
        }
        else if($paramCredit == "good_price_to_credit_ratio")
        {
            $creditLengkap = "Good Price to Credit Ratio";
        }
        else if($paramCredit == "AMT_CREDIT")
        {
            $creditLengkap = "Amount Credit";
        }
        else if($paramCredit == "DAYS_EMPLOYED")
        {
            $creditLengkap = "Days Employed";
        }
        else if($paramCredit == "DAYS_BIRTH")
        {
            $creditLengkap = "Days Birth";
        }
        else if($paramCredit == "MAX_DAYS_CREDIT")
        {
            $creditLengkap = "Max Days Credit";
        }
        else if($paramCredit == "AVG_DAYS_DECISION")
        {
            $creditLengkap = "Average Days Decision";
        }
        else if($paramCredit == "REGION_RATING_CLIENT_W_CITY")
        {
            $creditLengkap = "Region Rating Client with City";
        }
        else if($paramCredit == "MAX_RATE_DOWN_PAYMENT")
        {
            $creditLengkap = "Maximum Rate Down Payment";
        }

        return $creditLengkap;
    }

    function getParamsLengkapECommerce($paramECommerce)
    {
        $eCommerceLengkap = "";

        if($paramECommerce == "avg_web_browser_trans_device")
        {
            $eCommerceLengkap = "Average Web Browser Trans Device";
        }
        else if($paramECommerce == "avg_nondiscounted_product")
        {
            $eCommerceLengkap = "Average Non-Discounted Product";
        }
        else if($paramECommerce == "avg_mobile_app_trans_device")
        {
            $eCommerceLengkap = "Average Mobile App Transaction Device";
        }
        else if($paramECommerce == "sum_transaction_value")
        {
            $eCommerceLengkap = "Sum Transaction Value";
        }
        else if($paramECommerce == "avg_other_product")
        {
            $eCommerceLengkap = "Average Other Product";
        }
        else if($paramECommerce == "avg_ewallet_payment")
        {
            $eCommerceLengkap = "Average E-Wallet Payment";
        }
        else if($paramECommerce == "cosmetics_product_count")
        {
            $eCommerceLengkap = "Cosmetics Product Count";
        }
        else if($paramECommerce == "Nondiscounted_product_count")
        {
            $eCommerceLengkap = "Non-Discounted Product Count";
        }
        else if($paramECommerce == "avg_cc_payment")
        {
            $eCommerceLengkap = "Average Credit Card Payment";
        }
        else if($paramECommerce == "avg_cosmetics_product")
        {
            $eCommerceLengkap = "Average Cosmetics Product";
        }
        else if($paramECommerce == "elektronics_product_count")
        {
            $eCommerceLengkap = "Electronics Product Count";
        }
        else if($paramECommerce == "avg_transaction_value")
        {
            $eCommerceLengkap = "Average Transaction Value";
        }
        else if($paramECommerce == "avg_conv_store_payment")
        {
            $eCommerceLengkap = "Average Convenience Store Payment";
        }
        else if($paramECommerce == "transaction")
        {
            $eCommerceLengkap = "Transaction";
        }
        else if($paramECommerce == "avg_food_product")
        {
            $eCommerceLengkap = "Average Food Product";
        }
        else if($paramECommerce == "avg_bank_tf_payment")
        {
            $eCommerceLengkap = "Average Bank Transfer Payment";
        }
        else if($paramECommerce == "avg_discounted_product")
        {
            $eCommerceLengkap = "Average Discounted Product";
        }
        else if($paramECommerce == "avg_other_payment")
        {
            $eCommerceLengkap = "Average Other Payment";
        }
        else if($paramECommerce == "avg_other_payment")
        {
            $eCommerceLengkap = "Average Other Payment";
        }
        else if($paramECommerce == "avg_elektronics_product")
        {
            $eCommerceLengkap = "Average Electronics Product";
        }
        else if($paramECommerce == "mobile_app_trans_device_count")
        {
            $eCommerceLengkap = "Mobile App Transaction Device Count";
        }
        else if($paramECommerce == "avg_baby_products")
        {
            $eCommerceLengkap = "Average Baby Products";
        }
        else if($paramECommerce == "avg_clothes_product")
        {
            $eCommerceLengkap = "Average Clothes Product";
        }
        else if($paramECommerce == "clothes_product_count")
        {
            $eCommerceLengkap = "Clothes Product Count";
        }

        return $eCommerceLengkap;
    }