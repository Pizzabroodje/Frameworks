<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    public function users() {
        return $this->belongsToMany('App\User', 'user_tournament');
    }

    public static function dutchTimeString($time) {
        $days = array(
            "monday"   => "Maandag",
            "tuesday"   => "Dinsdag",
            "wednesday"  => "Woensdag",
            "thursday" => "Donderdag",
            "friday"   => "Vrijdag",
            "saturday"  => "Zaterdag",
            "sunday"    => "Zondag"
        );

        $months = array(
            "january"   => "Januari",
            "february"  => "Februari",
            "march"     => "Maart",
            "april"     => "April",
            "may"       => "Mei",
            "june"      => "Juni",
            "july"      => "Juli",
            "august"  => "Augustus",
            "september" => "September",
            "october"   => "Oktober",
            "november"  => "November",
            "december"  => "December"
        );

        $array = explode(" ", $time);
        $array[0] = $days[strtolower($array[0])];
        $array[2] = $months[strtolower($array[2])];
        return (implode(" ", $array));
    }
}
