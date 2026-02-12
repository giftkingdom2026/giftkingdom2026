<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

use App\Models\Core\Pages;

use URL;

class Analytics extends Model
{

    protected $table = 'analytics';

    protected $guarded = [];


    public static function recorduser($data,$request){

        session_start();

        $data = json_decode($data);

        $check = self::where('user_ip' , $data->geoplugin_request)->first();

        if( isset( $_SESSION['user'] ) ) :

            $check = $check->toArray();

            $pagedata = unserialize( $check['user_page_visits'] );

            foreach ($pagedata as $key => $page) :

                if( $key == $request->page ) :

                    $pagedata[$key] = ($page+1);

                else :

                    $pagedata[$request->page] = 1;

                endif;


            endforeach;

            $pagedata = serialize($pagedata);

            self::where('user_ip',$data->geoplugin_request)->update([

                'user_page_visits' => $pagedata,

            ]);

        else :

            $_SESSION['user'] = $data->geoplugin_request;

            if( empty($check) ) :

                self::Create([

                    'user_ip' => $data->geoplugin_request,
                    'user_visit_count' => serialize([date('F') => 1 ]),
                    'user_page_visits' => serialize([$request->page => 1 ]),
                    'user_country' => $data->geoplugin_countryName,
                    'user_timezone' => $data->geoplugin_timezone,

                ]); 


            else :

                $check = $check->toArray();

                $pagedata = unserialize( $check['user_page_visits'] );

                $monthdata = unserialize( $check['user_visit_count'] );

                foreach ($pagedata as $key => $page) :

                    if( $key == $request->page ) :

                        $pagedata[$key] = ($page+1);

                    else :

                        $pagedata[$request->page] = 1;

                    endif;

                endforeach;

                foreach( $monthdata as $key => $data) :

                    if( $key == date('F') ) :

                        $monthdata[$key] = ($data+1);

                    else :

                        $monthdata[ date('F') ] = $data;

                    endif;
                    
                endforeach;

                $monthdata = serialize($monthdata);

                $pagedata = serialize($pagedata);

                self::where('user_ip',$data->geoplugin_request)->update([

                    'user_visit_count' => $monthdata,
                    'user_page_visits' => $pagedata,

                ]);

            endif;

        endif;


    }


    public static function getData(){

        $users = self::get()->toArray();

        $usersbymonth = [];

        $pagevisitsz = 0;
        
        $countrycount = [];

        foreach( $users as $user ) :

            $months = unserialize($user['user_visit_count']);
            
            $pages = unserialize($user['user_page_visits']);

            foreach( $months as $month => $visits ) :

                isset( $usersbymonth[$month] ) ? $add = $usersbymonth[$month]['total'] : $add = 0;

                isset( $usersbymonth[$month][$user['user_country']]  ) ? $addc =  $usersbymonth[$month][$user['user_country']] : $addc = 0;

                isset( $countrycount[$user['user_country']]  ) ? $addcc =  $countrycount[$user['user_country']] : $addcc = 0;

                $usersbymonth[$month]['total'] = ( $add + $visits ) ;

                $usersbymonth[$month][$user['user_country']] = ($visits + $addc);

                $countrycount[$user['user_country']] = ($visits + $addcc);

            endforeach;

            foreach( $pages as $page => $visits ) :

                $pagevisitsz+=$visits;

            endforeach;

        endforeach;

        $result['pagevisitsz'] = $pagevisitsz;

        $result['users_by_month'] = $usersbymonth;

        $result['countrycount'] = $countrycount;

        return $result;
    }

}
