<?php

class AbstractDefaultLocale extends Locale
{

    // VARIABLES


    protected $ago = "ago";
    protected $year = "year";
    protected $years = "years";
    protected $month = "month";
    protected $months = "months";
    protected $week = "week";
    protected $weeks = "weeks";
    protected $day = "day";
    protected $days = "days";
    protected $hour = "hour";
    protected $hours = "hours";
    protected $minute = "minute";
    protected $minutes = "minutes";
    protected $min = "min";
    protected $mins = "mins";
    protected $second = "seconds";
    protected $seconds = "seconds";
    protected $sec = "sec";
    protected $secs = "secs";

    protected $updated = "updated";
    protected $registered = "registered";

    protected $none = "none";
    protected $delete = "delete";
    protected $deleting = "deleting";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param integer $date_time
     * @return string Time since
     */
    function timeSince( $date_time )
    {
        // array of time period chunks
        $chunks = array ( array ( 60 * 60 * 24 * 365, "year" ), array ( 60 * 60 * 24 * 30, "month" ),
                array ( 60 * 60 * 24 * 7, "week" ), array ( 60 * 60 * 24, "day" ), array ( 60 * 60, "hour" ),
                array ( 60, "min" ) );

        $today = time(); /* Current unix time  */
        $since = $today - $date_time;

        if ( $since > 604800 )
        {
            $print = date( "M jS", $date_time );

            if ( $since > 31536000 )
            {
                $print .= ", " . date( "Y", $date_time );
            }

            return $print;

        }

        // $j saves performing the count function each time around the loop
        for ( $i = 0, $j = count( $chunks ); $i < $j; $i++ )
        {

            $seconds = $chunks[ $i ][ 0 ];
            $name = $chunks[ $i ][ 1 ];

            // finding the biggest chunk (if the chunk fits, break)
            if ( ( $count = floor( $since / $seconds ) ) != 0 )
            {
                // DEBUG print "<!-- It's $name -->\n";
                break;
            }
        }

        $print = ( $count == 1 ) ? '1 ' . $name : "$count {$name}s";

        return sprintf( "%s %s", $print, $this->getAgo() );

    }

    /**
     * @param string $format
     * @param mixed $start Unixtime or date
     * @param mixed $end [NULL] Unixtime or date, current time if null
     */
    function timeDiff( $format, $start, $end = NULL )
    {
        if ( is_string( $end ) )
        {
            $end = strtotime( $end );
            if ( !$end )
            {
                return date( "d M. Y - H:i", $start );
            }
        }
        if ( !$end )
        {
            $end = time();
        }
        if ( is_string( $start ) )
        {
            $start = strtotime( $start );
        }
        if ( !$start || !is_numeric( $start ) )
        {
            return date( "d M. Y - H:i", $start );
        }

        $d_start = new DateTime();
        $d_start->setTimestamp( $start );
        $d_end = new DateTime();
        $d_end->setTimestamp( $end );
        $diff = $d_start->diff( $d_end );

        $diff_array = array ();
        $diff_array[ "year" ] = intval( $diff->format( '%y' ) );
        $diff_array[ "month" ] = intval( $diff->format( '%m' ) );
        $diff_array[ "day" ] = intval( $diff->format( '%d' ) );
        $diff_array[ "days" ] = intval( $diff->format( '%a' ) );
        $diff_array[ "week" ] = floor( $diff_array[ "day" ] / 7 );
        $diff_array[ "week_day" ] = floor( $diff_array[ "day" ] % 7 );
        $diff_array[ "hour" ] = intval( $diff->format( '%h' ) );
        $diff_array[ "min" ] = intval( $diff->format( '%i' ) );
        $diff_array[ "sec" ] = intval( $diff->format( '%s' ) );

        $format_return = array ();

        foreach ( $diff_array as $type => $value )
        {
            if ( $value > 0 )
            {
                switch ( $type )
                {
                    case "year" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getYear(), $this->getYears() ) );
                        break;
                    case "month" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getMonth(), $this->getMonths() ) );
                        break;
                    case "day" :
                    case "week_day" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getDay(), $this->getDays() ) );
                        break;
                    case "week" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getWeek(), $this->getWeeks() ) );
                        break;
                    case "hour" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getHour(), $this->getHours() ) );
                        break;
                    case "min" :
                        $format_return[] = sprintf( "%d %s", $value,
                                $this->quantity( $value, $this->getMin(), $this->getMins() ) );
                        break;
                }
            }
        }

        if ( !$format_return )
        {
            $format_return[] = "Now";
        }

        return implode( ", ", $format_return );
    }

    /**
     * @param integer $number
     * @param string $singular
     * @param string $plural
     */
    public function quantity( $number, $singular, $plural )
    {
        return $number == 1 ? $singular : $plural;
    }

    // ... GET


    // ... /GET


    // /FUNCTIONS


    public function getYear()
    {
        return $this->year;
    }

    public function getYears()
    {
        return $this->years;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getMonths()
    {
        return $this->months;
    }

    public function getWeek()
    {
        return $this->week;
    }

    public function getWeeks()
    {
        return $this->weeks;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getSecond()
    {
        return $this->second;
    }

    public function getSeconds()
    {
        return $this->seconds;
    }

    public function getSec()
    {
        return $this->sec;
    }

    public function getSecs()
    {
        return $this->secs;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function getMinute()
    {
        return $this->minute;
    }

    public function getMinutes()
    {
        return $this->minutes;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMins()
    {
        return $this->mins;
    }

    public function getAgo()
    {
        return $this->ago;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function getNone()
    {
        return $this->none;
    }

    public function getDelete()
    {
        return $this->delete;
    }

    public function getDeleting()
    {
        return $this->deleting;
    }

    public function getActivity( $registered, $updated = null )
    {
        $activityTime = $updated ? $updated : $registered;
        return sprintf( "%s %s",
                ucfirst( $updated ? $this->getUpdated() : $this->getRegistered() ),
                $this->timeSince( $activityTime ) );
    }

}

?>