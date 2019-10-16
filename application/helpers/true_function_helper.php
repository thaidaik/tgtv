<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convertMilion'))
{
    function convertMilion($price)
    {
        $pricedata = (float) $price / 1000000;
        $convert = $pricedata . ' m VND';
        return $convert;
    }

}
if ( ! function_exists('convertDateStyle'))
{
    function convertDateStyle($date, $style="d/m/Y")
    {
        $convertdate = date($style, strtotime($date));
        return $convertdate;
    }

}
if ( ! function_exists('convertDateDMY'))
{
    function convertDateDMY($date)
    {
        $convertdate = date("d/m/Y", strtotime($date));
        return $convertdate;
    }

}
if ( ! function_exists('checkDateData'))
{
    function checkDateData($date)
    {
        $month_tour = date('m_Y');
        $checkDateArray[$month_tour] = 'mnow';

        $month_tour_1 = date('m_Y', strtotime('+1 month', strtotime(date("Y-m-01"))));
        $checkDateArray[$month_tour_1] = 'mnowst';

        $month_tour_2 = date('m_Y', strtotime('+2 month', strtotime(date("Y-m-01"))));
        $checkDateArray[$month_tour_2] = 'mnownd';

        $month_tour_3 = date('m_Y', strtotime('+3 month', strtotime(date("Y-m-01"))));
        $checkDateArray[$month_tour_3] = 'mnowrd';

        $month_tour_check = date('m_Y', strtotime($date));
        $get_checkdate = $checkDateArray[$month_tour_check];
        return $get_checkdate;
    }

}
if ( ! function_exists('truncateWords'))
{
    function truncateWords($text, $limit, $ellipsis = '...') {
        $words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $limit ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $ellipsis;
        }
        return $text;
    }
}
if ( ! function_exists('randomPassword'))
{
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
if ( ! function_exists('initials'))
{
    function initials($str) {
        $ret = '';
        foreach (explode(' ', $str) as $word)
            $ret .= strtoupper($word[0]);
        return $ret;
    }
}

if ( ! function_exists('testopenwindow'))
{
    function testopenwindow($guest_sale_tour_info_data) {
        if(isset($guest_sale_tour_info_data)){ ?>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="">Update Payment</th>
                    <th class="">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $this->load->helper('true_function');
                foreach($guest_sale_tour_info_data as $row)
                {
                    $link = "'".site_url("tour")."/info/update/".$row['tour_id']."'";
                    echo '<tr>';
                    echo '<td><a href="javascript: openwindow('.$link.')" class="btn btn-success">Update</a></td>';
                    echo '<td class="crud-actions">
                          <a href="'.site_url("guest").'/link/tour/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$row['guest_tour_link_id'].'" class="btn btn-info">edit</a>  
                        </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <script>
                function openwindow(url)
                {
                    window.open(url,"mywindow","menubar=1,resizable=1,width=850,height=850");
                }
            </script>
            <hr class="style1">
            <?php
        }
    }
}
