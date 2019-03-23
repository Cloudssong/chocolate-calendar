<html>
<head>
<style type="text/css">
a:hover {
    text-decoration: underline;
    background: #eaeaea;
}
.calender {
    margin: auto;
    width:280px;
    border:1px solid black;
}
.calendar body {
    font-family:verdana;
    font-size:12px;
    background-color: green;
}
.calendar a {
    color:black;
    text-decoration: none;
}

* html .calender,
* + html .calender {
    width:282px;
}
.calender div.after,
.calender div.before{
    color:silver;
}
.day {
    float:left;
    width:40px;
    height:40px;
    line-height: 40px;
    text-align: center;
}
.day.headline {
    background:silver;
    font-weight: bold;
    border-bottom: 1px solid black;
}
.day.current {
    font-weight:bold;
    background-color: #C3C9C0;
}
.clear {
    clear:left;
}
.pagination {
    text-align: center;
    height:20px;
    line-height:20px;
    font-weight: bold;
}
.pagihead { 
display:inline-block;
background: white;
width: 140px;
height: 20px;
color: black;
}
.pagination a {
    width:20px;
    height:20px;
}

.active {
    background-color: #BBE3A6;
}
</style>
</head>
<body>

<?php
// Jump to last month
function monthBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)-1,date("d",$timestamp),date("Y",$timestamp) );
}

// Jump to last year
function yearBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)-1 );
}

// Jump to next month
function monthForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)+1,date("d",$timestamp),date("Y",$timestamp) );
}

// Jump to next year
function yearForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)+1 );
}

function getCalender($date,$headline = array('Mo','Di','Mi','Do','Fr','Sa','So')) {
    $out = "";

    // Perparation to set monthnames to German
    $arrMonth = array(
        "January" => "Januar",
        "February" => "Februar",
        "March" => "M&auml;rz",
        "April" => "April",
        "May" => "Mai",
        "June" => "Juni",
        "July" => "Juli",
        "August" => "August",
        "September" => "September",
        "October" => "Oktober",
        "November" => "November",
        "December" => "Dezember"
    );
    
    
    $out .= <<<CAL
    <!-- Wrapper for Calendar CSS and toggle-function for days -->
    <div class="calender" id="chocToggle">
        <div class="pagination">
            <!-- Creates buttons for earlier defined maneuvering functions -->
            <a href="?timestamp={yearBack($date);}" class="last">|&laquo;</a> 
            <a href="?timestamp={monthBack($date);}" class="last">&laquo;</a> 
            <!-- Head to put out current month and year -->
            <div class="pagihead">
            <span> {$arrMonth[date('F',$date)]}  {date('Y',$date);}</span>
            </div>
            <!-- Creates buttons for earlier defined maneuvering functions -->
            <a href="?timestamp={monthForward($date);}" class="next">&raquo;</a>
            <a href="?timestamp={yearForward($date);}" class="next">&raquo;|</a>  
        </div>
        <!-- Makes sure there's no floating elements on the left side -->
        <div class="clear"></div>
    </div>
CAL;
    

    // Days of the calendar month
    $sum_days = date('t',$date);
    // Days of the last month
    $LastMonthSum = date('t',mktime(0,0,0,(date('m',$date)-1),0,date('Y',$date)));
    
    foreach( $headline as $key => $value ) {
        $out .= "<div class='day headline'>".$value."</div>\n";
    }
    
    // If smaller then months ought to be in this month -> add a day
    for( $i = 1; $i <= $sum_days; $i++ ) {
        // Gets the day of the week (3 letters)
        $day_name = date('D',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        // Gets the day of the week (numeric)
        $day_number = date('w',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
         // Gets the days datum
        $days_date = date('Y-m-d', mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        // $out .= $days_date;
        
        // If it's the first of the month
        if( $i == 1) {
            // Defines 'todays' day of the week
            $s = array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'));
            // If the 'today' is the first day of the month and no monday -> print the last days of last month until it's monday
            for( $b = $s; $b > 0; $b-- ) {
                $x = $LastMonthSum-$b;
                $out .= '<div class="day before" data-mydate="' . $days_date . '">'.sprintf("%02d",$x)."</div>\n";
            }
        } 
        
        // Checks if it's today -> adds style
        if( $i == date('d',$date) && date('m.Y',$date) == date('m.Y')) {
            $out .= '<div class="day current" data-mydate="' . $days_date . '">'.sprintf("%02d",$i)."</div>\n";
        } else {
            $out .= '<div class="day normal" data-mydate="' . $days_date . '">'.sprintf("%02d",$i)."</div>\n";
        }
        
        // Create new days until sunday, then start new week in new line
        if( $i == $sum_days) {
            $next_sum = (6 - array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun')));
            for( $c = 1; $c <=$next_sum; $c++) {
                $out .= '<div class="day after" > '.sprintf("%02d",$c)." </div>\n"; 
            }
        }
    }
    return $out;
    
}


// If there is a timestamp -> set date to current timestamp
if( isset($_REQUEST['timestamp'])) $date = $_REQUEST['timestamp'];
// If not get new timestamp
else $date = time();


// Perparation for the output of the Headline in German
$headline = array('Mo','Di','Mi','Do','Fr','Sa','So');

// Creates the calendar
echo getCalender($date,$headline);
?>

</body>
</html>