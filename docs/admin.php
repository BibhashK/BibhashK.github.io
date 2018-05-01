<?php
require_once( dirname(__FILE__).'/form.lib.php' );

define( 'PHPFMG_USER', "bibhashkalita94@gmail.com" ); // must be a email address. for sending password to you.
define( 'PHPFMG_PW', "f3fe84" );

?>
<?php
/**
 * GNU Library or Lesser General Public License version 2.0 (LGPLv2)
*/

# main
# ------------------------------------------------------
error_reporting( E_ERROR ) ;
phpfmg_admin_main();
# ------------------------------------------------------




function phpfmg_admin_main(){
    $mod  = isset($_REQUEST['mod'])  ? $_REQUEST['mod']  : '';
    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : '';
    $function = "phpfmg_{$mod}_{$func}";
    if( !function_exists($function) ){
        phpfmg_admin_default();
        exit;
    };

    // no login required modules
    $public_modules   = false !== strpos('|captcha||ajax|', "|{$mod}|");
    $public_functions = false !== strpos('|phpfmg_ajax_submit||phpfmg_mail_request_password||phpfmg_filman_download||phpfmg_image_processing||phpfmg_dd_lookup|', "|{$function}|") ;   
    if( $public_modules || $public_functions ) { 
        $function();
        exit;
    };
    
    return phpfmg_user_isLogin() ? $function() : phpfmg_admin_default();
}

function phpfmg_ajax_submit(){
    $phpfmg_send = phpfmg_sendmail( $GLOBALS['form_mail'] );
    $isHideForm  = isset($phpfmg_send['isHideForm']) ? $phpfmg_send['isHideForm'] : false;

    $response = array(
        'ok' => $isHideForm,
        'error_fields' => isset($phpfmg_send['error']) ? $phpfmg_send['error']['fields'] : '',
        'OneEntry' => isset($GLOBALS['OneEntry']) ? $GLOBALS['OneEntry'] : '',
    );
    
    @header("Content-Type:text/html; charset=$charset");
    echo "<html><body><script>
    var response = " . json_encode( $response ) . ";
    try{
        parent.fmgHandler.onResponse( response );
    }catch(E){};
    \n\n";
    echo "\n\n</script></body></html>";

}


function phpfmg_admin_default(){
    if( phpfmg_user_login() ){
        phpfmg_admin_panel();
    };
}



function phpfmg_admin_panel()
{    
    if( !phpfmg_user_isLogin() ){
        exit;
    };

    phpfmg_admin_header();
    phpfmg_writable_check();
?>    
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign=top style="padding-left:280px;">

<style type="text/css">
    .fmg_title{
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
    }
    
    .fmg_sep{
        width:32px;
    }
    
    .fmg_text{
        line-height: 150%;
        vertical-align: top;
        padding-left:28px;
    }

</style>

<script type="text/javascript">
    function deleteAll(n){
        if( confirm("Are you sure you want to delete?" ) ){
            location.href = "admin.php?mod=log&func=delete&file=" + n ;
        };
        return false ;
    }
</script>


<div class="fmg_title">
    1. Email Traffics
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=1">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=1">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_EMAILS_LOGFILE) ){
            echo '<a href="#" onclick="return deleteAll(1);">delete all</a>';
        };
    ?>
</div>


<div class="fmg_title">
    2. Form Data
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=2">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=2">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_SAVE_FILE) ){
            echo '<a href="#" onclick="return deleteAll(2);">delete all</a>';
        };
    ?>
</div>

<div class="fmg_title">
    3. Form Generator
</div>
<div class="fmg_text">
    <a href="http://www.formmail-maker.com/generator.php" onclick="document.frmFormMail.submit(); return false;" title="<?php echo htmlspecialchars(PHPFMG_SUBJECT);?>">Edit Form</a> &nbsp;&nbsp;
    <a href="http://www.formmail-maker.com/generator.php" >New Form</a>
</div>
    <form name="frmFormMail" action='http://www.formmail-maker.com/generator.php' method='post' enctype='multipart/form-data'>
    <input type="hidden" name="uuid" value="<?php echo PHPFMG_ID; ?>">
    <input type="hidden" name="external_ini" value="<?php echo function_exists('phpfmg_formini') ?  phpfmg_formini() : ""; ?>">
    </form>

		</td>
	</tr>
</table>

<?php
    phpfmg_admin_footer();
}



function phpfmg_admin_header( $title = '' ){
    header( "Content-Type: text/html; charset=" . PHPFMG_CHARSET );
?>
<html>
<head>
    <title><?php echo '' == $title ? '' : $title . ' | ' ; ?>PHP FormMail Admin Panel </title>
    <meta name="keywords" content="PHP FormMail Generator, PHP HTML form, send html email with attachment, PHP web form,  Free Form, Form Builder, Form Creator, phpFormMailGen, Customized Web Forms, phpFormMailGenerator,formmail.php, formmail.pl, formMail Generator, ASP Formmail, ASP form, PHP Form, Generator, phpFormGen, phpFormGenerator, anti-spam, web hosting">
    <meta name="description" content="PHP formMail Generator - A tool to ceate ready-to-use web forms in a flash. Validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. ">
    <meta name="generator" content="PHP Mail Form Generator, phpfmg.sourceforge.net">

    <style type='text/css'>
    body, td, label, div, span{
        font-family : Verdana, Arial, Helvetica, sans-serif;
        font-size : 12px;
    }
    </style>
</head>
<body  marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">

<table cellspacing=0 cellpadding=0 border=0 width="100%">
    <td nowrap align=center style="background-color:#024e7b;padding:10px;font-size:18px;color:#ffffff;font-weight:bold;width:250px;" >
        Form Admin Panel
    </td>
    <td style="padding-left:30px;background-color:#86BC1B;width:100%;font-weight:bold;" >
        &nbsp;
<?php
    if( phpfmg_user_isLogin() ){
        echo '<a href="admin.php" style="color:#ffffff;">Main Menu</a> &nbsp;&nbsp;' ;
        echo '<a href="admin.php?mod=user&func=logout" style="color:#ffffff;">Logout</a>' ;
    }; 
?>
    </td>
</table>

<div style="padding-top:28px;">

<?php
    
}


function phpfmg_admin_footer(){
?>

</div>

<div style="color:#cccccc;text-decoration:none;padding:18px;font-weight:bold;">
	:: <a href="http://phpfmg.sourceforge.net" target="_blank" title="Free Mailform Maker: Create read-to-use Web Forms in a flash. Including validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. " style="color:#cccccc;font-weight:bold;text-decoration:none;">PHP FormMail Generator</a> ::
</div>

</body>
</html>
<?php
}


function phpfmg_image_processing(){
    $img = new phpfmgImage();
    $img->out_processing_gif();
}


# phpfmg module : captcha
# ------------------------------------------------------
function phpfmg_captcha_get(){
    $img = new phpfmgImage();
    $img->out();
    //$_SESSION[PHPFMG_ID.'fmgCaptchCode'] = $img->text ;
    $_SESSION[ phpfmg_captcha_name() ] = $img->text ;
}



function phpfmg_captcha_generate_images(){
    for( $i = 0; $i < 50; $i ++ ){
        $file = "$i.png";
        $img = new phpfmgImage();
        $img->out($file);
        $data = base64_encode( file_get_contents($file) );
        echo "'{$img->text}' => '{$data}',\n" ;
        unlink( $file );
    };
}


function phpfmg_dd_lookup(){
    $paraOk = ( isset($_REQUEST['n']) && isset($_REQUEST['lookup']) && isset($_REQUEST['field_name']) );
    if( !$paraOk )
        return;
        
    $base64 = phpfmg_dependent_dropdown_data();
    $data = @unserialize( base64_decode($base64) );
    if( !is_array($data) ){
        return ;
    };
    
    
    foreach( $data as $field ){
        if( $field['name'] == $_REQUEST['field_name'] ){
            $nColumn = intval($_REQUEST['n']);
            $lookup  = $_REQUEST['lookup']; // $lookup is an array
            $dd      = new DependantDropdown(); 
            echo $dd->lookupFieldColumn( $field, $nColumn, $lookup );
            return;
        };
    };
    
    return;
}


function phpfmg_filman_download(){
    if( !isset($_REQUEST['filelink']) )
        return ;
        
    $filelink =  base64_decode($_REQUEST['filelink']);
    $file = PHPFMG_SAVE_ATTACHMENTS_DIR . basename($filelink);

    // 2016-12-05:  to prevent *LFD/LFI* attack. patch provided by Pouya Darabi, a security researcher in cert.org
    $real_basePath = realpath(PHPFMG_SAVE_ATTACHMENTS_DIR); 
    $real_requestPath = realpath($file);
    if ($real_requestPath === false || strpos($real_requestPath, $real_basePath) !== 0) { 
        return; 
    }; 

    if( !file_exists($file) ){
        return ;
    };
    
    phpfmg_util_download( $file, $filelink );
}


class phpfmgDataManager
{
    var $dataFile = '';
    var $columns = '';
    var $records = '';
    
    function __construct(){
        $this->dataFile = PHPFMG_SAVE_FILE; 
    }

    function phpfmgDataManager(){
        $this->dataFile = PHPFMG_SAVE_FILE; 
    }
    
    function parseFile(){
        $fp = @fopen($this->dataFile, 'rb');
        if( !$fp ) return false;
        
        $i = 0 ;
        $phpExitLine = 1; // first line is php code
        $colsLine = 2 ; // second line is column headers
        $this->columns = array();
        $this->records = array();
        $sep = chr(0x09);
        while( !feof($fp) ) { 
            $line = fgets($fp);
            $line = trim($line);
            if( empty($line) ) continue;
            $line = $this->line2display($line);
            $i ++ ;
            switch( $i ){
                case $phpExitLine:
                    continue;
                    break;
                case $colsLine :
                    $this->columns = explode($sep,$line);
                    break;
                default:
                    $this->records[] = explode( $sep, phpfmg_data2record( $line, false ) );
            };
        }; 
        fclose ($fp);
    }
    
    function displayRecords(){
        $this->parseFile();
        echo "<table border=1 style='width=95%;border-collapse: collapse;border-color:#cccccc;' >";
        echo "<tr><td>&nbsp;</td><td><b>" . join( "</b></td><td>&nbsp;<b>", $this->columns ) . "</b></td></tr>\n";
        $i = 1;
        foreach( $this->records as $r ){
            echo "<tr><td align=right>{$i}&nbsp;</td><td>" . join( "</td><td>&nbsp;", $r ) . "</td></tr>\n";
            $i++;
        };
        echo "</table>\n";
    }
    
    function line2display( $line ){
        $line = str_replace( array('"' . chr(0x09) . '"', '""'),  array(chr(0x09),'"'),  $line );
        $line = substr( $line, 1, -1 ); // chop first " and last "
        return $line;
    }
    
}
# end of class



# ------------------------------------------------------
class phpfmgImage
{
    var $im = null;
    var $width = 73 ;
    var $height = 33 ;
    var $text = '' ; 
    var $line_distance = 8;
    var $text_len = 4 ;

    function __construct( $text = '', $len = 4 ){
        $this->phpfmgImage( $text, $len );
    }

    function phpfmgImage( $text = '', $len = 4 ){
        $this->text_len = $len ;
        $this->text = '' == $text ? $this->uniqid( $this->text_len ) : $text ;
        $this->text = strtoupper( substr( $this->text, 0, $this->text_len ) );
    }
    
    function create(){
        $this->im = imagecreate( $this->width, $this->height );
        $bgcolor   = imagecolorallocate($this->im, 255, 255, 255);
        $textcolor = imagecolorallocate($this->im, 0, 0, 0);
        $this->drawLines();
        imagestring($this->im, 5, 20, 9, $this->text, $textcolor);
    }
    
    function drawLines(){
        $linecolor = imagecolorallocate($this->im, 210, 210, 210);
    
        //vertical lines
        for($x = 0; $x < $this->width; $x += $this->line_distance) {
          imageline($this->im, $x, 0, $x, $this->height, $linecolor);
        };
    
        //horizontal lines
        for($y = 0; $y < $this->height; $y += $this->line_distance) {
          imageline($this->im, 0, $y, $this->width, $y, $linecolor);
        };
    }
    
    function out( $filename = '' ){
        if( function_exists('imageline') ){
            $this->create();
            if( '' == $filename ) header("Content-type: image/png");
            ( '' == $filename ) ? imagepng( $this->im ) : imagepng( $this->im, $filename );
            imagedestroy( $this->im ); 
        }else{
            $this->out_predefined_image(); 
        };
    }

    function uniqid( $len = 0 ){
        $md5 = md5( uniqid(rand()) );
        return $len > 0 ? substr($md5,0,$len) : $md5 ;
    }
    
    function out_predefined_image(){
        header("Content-type: image/png");
        $data = $this->getImage(); 
        echo base64_decode($data);
    }
    
    // Use predefined captcha random images if web server doens't have GD graphics library installed  
    function getImage(){
        $images = array(
			'2770' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7WANEQ11DA1qRxUSmMDQ6NARMdUASA6oAiQUEIOtuBcJGRwcRZPdNA8KlK7OmIbsvAAinMMLUgSGjA6MDQwCqGCsQgkSR7RABQtYGBhS3hIaCxVDcPFDhR0WIxX0A2ejLivFd3LoAAAAASUVORK5CYII=',
			'1210' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7GB0YQximMLQii7E6sLYyhDBMdUASE3UQaXQMYQgIQNHL0OgwhdFBBMl9K7NWLV01bWXWNCT3AdVNYUCog4kFYIqBVaLZwdoAFEN1S4hoqGOoA4qbByr8qAixuA8Ajg7IkmIGWN0AAAAASUVORK5CYII=',
			'1162' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7GB0YAhhCGaY6IImxOjAGMDo6BAQgiYk6sAawNjg6iKDpZQXSIkjuW5m1Kmrp1FWropDcB1bn6NDogKE3oBXdLUCxKehiILcgi4mGsIYyhDKGhgyC8KMixOI+ALxtxw23nOg2AAAAAElFTkSuQmCC',
			'BAC4' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7QgMYAhhCHRoCkMQCpjCGMDoENKKItbK2sjYItKKqE2l0bWCYEoDkvtCoaStTV62KikJyH0Qd0EQU80RDgWKhIShiIHUCDeh2OAJ1IouFBog0OqC5eaDCj4oQi/sAooXQC4KGDeQAAAAASUVORK5CYII=',
			'B3FB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWklEQVR4nGNYhQEaGAYTpIn7QgNYQ1hDA0MdkMQCpoi0sjYwOgQgi7UyNLoCxURQ1DEgqwM7KTRqVdjS0JWhWUjuQ1OH2zysdmC6BezmBkYUNw9U+FERYnEfAC9MzCcDiuV6AAAAAElFTkSuQmCC',
			'9ADD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7WAMYAlhDGUMdkMREpjCGsDY6OgQgiQW0srayNgQ6iKCIiTS6IsTATpo2ddrK1FWRWdOQ3MfqiqIOAltFQ9HFBFox1YlMAYqhuYU1ACiG5uaBCj8qQizuAwBT7cyHOCBvlwAAAABJRU5ErkJggg==',
			'36ED' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7RAMYQ1hDHUMdkMQCprC2sjYwOgQgq2wVaQSJiSCLTRFpQBIDO2ll1LSwpaErs6Yhu2+KaCuGXqB5rkSIYXMLNjcPVPhREWJxHwCHzMofvZCCugAAAABJRU5ErkJggg==',
			'F558' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7QkNFQ1lDHaY6IIkFNIg0sDYwBARgiDE6iKCKhbBOhasDOyk0aurSpZlZU7OQ3AeUb3RoCEAzDyQWiG5eoyuGGGsro6MDml7GEIZQBhQ3D1T4URFicR8AAMrNuELIbqEAAAAASUVORK5CYII=',
			'99A2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAd0lEQVR4nGNYhQEaGAYTpIn7WAMYQximMEx1QBITmcLayhDKEBCAJBbQKtLo6OjoIIIm5toQ0CCC5L5pU5cuTV0VBYQI97G6MgYC1TUi28HQytDoGhrQiuwWgVYWkHlTGNDcwtoQEIDuZtaGwNCQQRB+VIRY3AcASxHNJUGn58AAAAAASUVORK5CYII=',
			'0464' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nM3QMQ6AIAwF0DL0BngfGNhrYhdOU4feAI7gwillLMqo0f7tJ01fCu02An/KKz4XQIFByHRIUF0Mu+18AUYJajtSl1CgkPHlo09tORsfqVeMMYy7CydZeRtvKHbJxaLdMnQz81f/ezAT3wniDszb16Nb+AAAAABJRU5ErkJggg==',
			'DE70' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7QgNEQ1lDA1qRxQKmiIDIqQ7IYq1gsYAAdLFGRwcRJPdFLZ0atmrpyqxpSO4Dq5vCCFOHEAvAFGN0YEC1A+gW1gYGFLeA3dzAgOLmgQo/KkIs7gMAFJDNdQGDDFwAAAAASUVORK5CYII=',
			'41D2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpI37pjAEsIYyTHVAFgthDGBtdAgIQBJjDGENYG0IdBBBEmMF6W0IaBBBct+0aauilq6KAkKE+wIg6hqR7QgNBYu1YrgFpBpdDOgWVDHWUNZQxtCQwRB+1INY3AcAUpPKw4wjmOMAAAAASUVORK5CYII=',
			'BFE9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QgNEQ11DHaY6IIkFTBFpYG1gCAhAFmsFiTE6iGCog4uBnRQaNTVsaeiqqDAk90HNmyqCYR5DAxYxLHaguiU0ACiG5uaBCj8qQizuAwD8fczYQv/iaQAAAABJRU5ErkJggg==',
			'2991' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGVqRxUSmsLYyOjpMRRYLaBVpdG0ICEXRDRGD6YW4adrSpZmZUUtR3BfAGOgQEoBiB6MDQ6NDA6oYawNLoyOamEgD2C0oYqGhYDeHBgyC8KMixOI+AJ68y8W0D9B/AAAAAElFTkSuQmCC',
			'A2AA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7GB0YQximMLQii7EGsLYyhDJMdUASE5ki0ujo6BAQgCQW0MrQ6NoQ6CCC5L6opauWLl0VmTUNyX1AdVNYEerAMDSUIYA1NDA0BMU8Rgd0dQGtrA2YYqKhrmhiAxV+VIRY3AcAZyvMpuEDWCAAAAAASUVORK5CYII=',
			'730A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QkNZQximMLSiiLaKtDKEMkx1QBFjaHR0dAgIQBYD6mNtCHQQQXZf1Kqwpasis6YhuY/RAUUdGLI2MDS6NgSGhiCJAeWBdjiiqAtoALmFEU0M5GZUsYEKPypCLO4DANDEywxbbnj5AAAAAElFTkSuQmCC',
			'25B2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nM2QPQ6AMAhG24Eb4H1Y3DEpi6ehQ2/QeoMuPaV0w+ioiXzbCz8vhHErDX/KJ37Ai4CERo5hRYVMzI5xMaYboZ8umKxP0fsdrXcZY/d+HPKaKfsbkYzZ1ouL4mTVM7tapotnIjGBREk/+N+LefA7Ae1zzMWB5c2kAAAAAElFTkSuQmCC',
			'BC17' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7QgMYQxmmMIaGIIkFTGFtdAhhaBBBFmsVaXBEF5sC5E0B0kjuC42atmrVtFUrs5DcB1XXyoBmHlBsCrqYwxSGAAZ0t0xhdEB3M2OoI4rYQIUfFSEW9wEA9wPNcERennQAAAAASUVORK5CYII=',
			'30B5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7RAMYAlhDGUMDkMQCpjCGsDY6OqCobGVtZW0IRBWbItLo2ujo6oDkvpVR01amhq6MikJ2H1idQ4MIinlAsYYANDGIHSIYbnEIQHYfxM0MUx0GQfhREWJxHwBYM8u1hkys3QAAAABJRU5ErkJggg==',
			'74C5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7QkMZWhlCHUMDkEVbGaYyOgQ6MKCKhbI2CKKKTWF0ZW1gdHVAdl/U0qVLV62MikJyH6ODSCsrkBZB0svaIBrqiiYGZLeC7EAWA7qrldEhICAATYwh1GGqwyAIPypCLO4DAPImyrOpU2IiAAAAAElFTkSuQmCC',
			'A645' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAeUlEQVR4nGNYhQEaGAYTpIn7GB0YQxgaHUMDkMRYA1hbGVodHZDViUwRaWSYiioW0CrSwBDo6OqA5L6opdPCVmZmRkUhuS+gVbSVtdGhQQRJb2ioSKMr0FYRVPMaHRodHVDFgG5pdAgIQBEDudlhqsMgCD8qQizuAwBhp8zg3tC08wAAAABJRU5ErkJggg==',
			'98DF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXElEQVR4nGNYhQEaGAYTpIn7WAMYQ1hDGUNDkMREprC2sjY6OiCrC2gVaXRtCEQTA6pDiIGdNG3qyrClqyJDs5Dcx+qKog4CsZgngEUMm1ugbkY1b4DCj4oQi/sADVzKUOjOyUsAAAAASUVORK5CYII=',
			'5E1E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QkNEQxmmMIYGIIkFNIg0MIQwOjCgiTGiiQUGANVNgYuBnRQ2bWrYqmkrQ7OQ3deKog6nWAAWMZEpmGKsAaKhjKGOKG4eqPCjIsTiPgCPEsk6q5dbMwAAAABJRU5ErkJggg==',
			'5A7C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7QkMYAlhDA6YGIIkFNDCGAMkAERQx1laGhkAHFiSxwACRRodGRwdk94VNm7Yya+nKLBT3tQLVTWF0QLG5VTTUIQBVLACoztGBEcUOkSkija4NDChuYQ0Ai6G4eaDCj4oQi/sAPP3MI9t7F10AAAAASUVORK5CYII=',
			'AC17' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7GB0YQxmmMIaGIImxBrA2OoQwNIggiYlMEWlwRBMLaAXypgBpJPdFLZ22atW0VSuzkNwHVdeKbG9oKFhsCgOaeQ5TGAJQxYBumcLogCrGGMoY6ogiNlDhR0WIxX0AZGLMeConqW0AAAAASUVORK5CYII=',
			'2752' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7WANEQ11DHaY6IImJTGFodG1gCAhAEgtoBYkxOogg625laGWdClSP7L5pq6YtzcxaFYXsvgAgbAhoRLaD0YHRAWwqslvAMGAKspgIEDI6OgQgi4WGAm0MZQwNGQThR0WIxX0AuNjLnSHDfEYAAAAASUVORK5CYII=',
			'EEA6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QkNEQxmmMEx1QBILaBBpYAhlCAhAE2N0dHQQQBNjbQh0QHZfaNTUsKWrIlOzkNwHVYdhHmtooIMIFvMwxQJQ9ILcDBRDcfNAhR8VIRb3AQAzwM1DHggSxwAAAABJRU5ErkJggg==',
			'DD98' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QgNEQxhCGaY6IIkFTBFpZXR0CAhAFmsVaXRtCHQQwRALgKkDOylq6bSVmZlRU7OQ3AdS5xASgGGeAxbzHNHFsLgFm5sHKvyoCLG4DwCQaM7iinJF9gAAAABJRU5ErkJggg==',
			'DBE2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7QgNEQ1hDHaY6IIkFTBFpZW1gCAhAFmsVaXRtYHQQQRUDqWsQQXJf1NKpYUtDgTSS+6DqGh0wzGNoZcAUm8KAxS2YbnYMDRkE4UdFiMV9AFCrzdaPftgeAAAAAElFTkSuQmCC',
			'79D1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7QkMZQ1hDGVpRRFtZW1kbHaaiiok0ujYEhKKITQGLwfRC3BS1dGkqkEB2H6MDYyCSOjBkbWBoRBcTaWDBEAtoALsFTQzs5tCAQRB+VIRY3AcAN1XNKWW+41AAAAAASUVORK5CYII=',
			'05A4' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nM2QsRGAIAxFk4INcB8s7MMdaZgmFtkAR6BhSikDWuppfvfu5/Iu0C4j8Ke84odhYSggZJgjL8CwW+aLF1yDWkbqkxMqZPxyPWptOWfjRwr7JjGMu51x5DTe6D2aXJy6iWHANLOv/vdgbvxOdgvOT0kf2ioAAAAASUVORK5CYII=',
			'A86B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7GB0YQxhCGUMdkMRYA1hbGR0dHQKQxESmiDS6Njg6iCCJBbSytrICTQhAcl/U0pVhS6euDM1Cch9YHZp5oaEg8wLRzMMmhumWgFZMNw9U+FERYnEfAGQny+TqeA/2AAAAAElFTkSuQmCC',
			'B017' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7QgMYAhimMIaGIIkFTGEMYQhhaBBBFmtlbWVEF5si0ugwBUgjuS80atrKrGmrVmYhuQ+qrpUBxTyw2BQGNDuAIgEM6G6ZwuiA7mbGUEcUsYEKPypCLO4DALE4zHAo63mFAAAAAElFTkSuQmCC',
			'E279' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QkMYQ1hDA6Y6IIkFNLC2AsmAABQxkUaHhkAHERQxhkaHRkeYGNhJoVGrlgJhVBiS+4DqpgDhVDS9AUDYgCrG6MDowIBmBysQMqC4JTRENNS1gQHFzQMVflSEWNwHAKQ/zRzCe4pLAAAAAElFTkSuQmCC',
			'478F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpI37poiGOoQyhoYgi4UwNDo6Ojogq2MEirk2BKKIsU5haGVEqAM7adq0VdNWha4MzUJyX8AUhgBGNPNCQxkdWNHMY5jC2oApJtKArhckxgDUPyjCj3oQi/sAcUHJELEn/DoAAAAASUVORK5CYII=',
			'2DA6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nGNYhQEaGAYTpIn7WANEQximMEx1QBITmSLSyhDKEBCAJBbQKtLo6OjoIICsGyjm2hDogOK+adNWpq6KTM1Cdl8AWB2KeYwOQLHQQAcRZLc0QMxDFhNpEGllbQhA0RsaKhoCFENx80CFHxUhFvcBALbqzN4muXsTAAAAAElFTkSuQmCC',
			'84F0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7WAMYWllDA1qRxUSmMExlbWCY6oAkBlQRChQLCEBRx+jK2sDoIILkvqVRS5cuDV2ZNQ3JfSJTRFqR1EHNEw11xRADugXDDrAYilvAbm5gQHHzQIUfFSEW9wEAC2XLTAghyK0AAAAASUVORK5CYII=',
			'CC91' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7WEMYQxlCGVqRxURaWRsdHR2mIosFNIo0uDYEhKKINYg0sDYEwPSCnRS1atqqlZlRS5HdB1LHEBLQiq6XoQFNDGiHI5oY1C0oYlA3hwYMgvCjIsTiPgBSZc0myvYcOgAAAABJRU5ErkJggg==',
			'4FE3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpI37poiGuoY6hDogi4WINLA2MDoEIIkxgsUYGkSQxFinQMQCkNw3bdrUsKWhq5ZmIbkvAFUdGIaGYprHMAWXGKpbwGLobh6o8KMexOI+ANVWy/7j+bFRAAAAAElFTkSuQmCC',
			'146B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7GB0YWhlCGUMdkMRYHRimMjo6OgQgiYk6MISyNjg6iKDoZXRlBZIBSO5bmbV06dKpK0OzkNzH6CDSyopmHqODaKhrQyCaeQytrFjEMNwSgunmgQo/KkIs7gMAuszH8VzyJc4AAAAASUVORK5CYII=',
			'A492' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nM2QvQ2AQAiFH8VtcO6DhT0m0twGboEFG+gIV+iUWuJPqYm87nsJfAHbbQx/yid+xHAoFg4sCRZqWSSwPEOT9ZwDE6cumVgOfqXWuo5lK8FPPDsGmeIN1Ub5aHDaByeT+cYOlyuDkg4/+N+LefDbASD1zGvfPzK9AAAAAElFTkSuQmCC',
			'1FDE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAVElEQVR4nGNYhQEaGAYTpIn7GB1EQ11DGUMDkMRYHUQaWBsdHZDViYLEGgIdUPWiiIGdtDJratjSVZGhWUjuYySsF78YultCgGJobh6o8KMixOI+AOmrx//EGQHmAAAAAElFTkSuQmCC',
			'6269' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdklEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGaY6IImJTGFtZXR0CAhAEgtoEWl0bXB0EEEWa2AAijHCxMBOioxatXTp1FVRYUjuC5nCMIXV0WEqit5WhgBWoAmoYowOQDEUO4BuaUB3C2uAaKgDmpsHKvyoCLG4DwAVLcwnu5tjiwAAAABJRU5ErkJggg==',
			'4AC7' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpI37pjAEMIQ6hoYgi4UwhjA6BDSIIIkxhrC2sjYIoIixThFpdAXSAUjumzZt2srUVatWZiG5LwCirhXZ3tBQ0VBXkO0obgGpEwhAF3N0CHRAF3MIdUQVG6jwox7E4j4ACI3MNgRSCJkAAAAASUVORK5CYII=',
			'D00E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWUlEQVR4nGNYhQEaGAYTpIn7QgMYAhimMIYGIIkFTGEMYQhldEBWF9DK2sro6IgmJtLo2hAIEwM7KWrptJWpqyJDs5Dch6YOjxgWO7C4BZubByr8qAixuA8A8OzLMHAgMt4AAAAASUVORK5CYII=',
			'CBD0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7WENEQ1hDGVqRxURaRVpZGx2mOiCJBTSKNLo2BAQEIIsBVbI2BDqIILkvatXUsKWrIrOmIbkPTR1MDGgemhgWO7C5BZubByr8qAixuA8ASEbN6danX1sAAAAASUVORK5CYII=',
			'2FC0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WANEQx1CHVqRxUSmiDQwOgRMdUASC2gVaWBtEAgIQNYNFmN0EEF237SpYUtXrcyahuy+ABR1YAjioYuxNmDaIdKA6ZbQUKAuNDcPVPhREWJxHwAwJMtbRDyFZQAAAABJRU5ErkJggg==',
			'F5F0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7QkNFQ1lDA1qRxQIaRBpYGximOmCKBQSgioWwNjA6iCC5LzRq6tKloSuzpiG5D6in0RWhDo+YCFAM3Q7WVky3MALtZUBx80CFHxUhFvcBABl7zPbzOYDBAAAAAElFTkSuQmCC',
			'8820' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGVqRxUSmsLYyOjpMdUASC2gVaXRtCAgIQFPH0BDoIILkvqVRK8NWrczMmobkPrC6VkaYOrh5DlOwiAUwYNjB6MCA4haQm1lDA1DcPFDhR0WIxX0A1LHL4uNYHtIAAAAASUVORK5CYII=',
			'8345' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WANYQxgaHUMDkMREpoi0MrQ6OiCrC2hlaHSYiiomMoWhlSHQ0dUByX1Lo1aFrczMjIpCch9IHWujQ4MImnmuQFvRxRwaHR1E0N3S6BCA7D6Imx2mOgyC8KMixOI+AIyIzLJ9qn1sAAAAAElFTkSuQmCC',
			'C985' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7WEMYQxhCGUMDkMREWllbGR0dHZDVBTSKNLo2BKKKNYg0Ojo6ujoguS9q1dKlWaEro6KQ3BfQwBgINK5BBEUvA9C8AFSxRhawHSIYbnEIQHYfxM0MUx0GQfhREWJxHwC0Ksv8FH/zVgAAAABJRU5ErkJggg==',
			'4418' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpI37pjC0AvFUB2SxEIapQBwQgCTGGMIQyhjC6CCCJMY6hdEVqBemDuykadOWLl01bdXULCT3BUwRaUVSB4ahoaKhDlNQzYO4BZsYql6QGGOoA6qbByr8qAexuA8Ap4DLMcDnXX4AAAAASUVORK5CYII=',
			'F334' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpIn7QkNZQxhDGRoCkMQCGkRaWRsdGlHFGBodGgJa0cRagaJTApDcFxq1KmzV1FVRUUjug6hzdMA0LzA0BNMObG5BE8N080CFHxUhFvcBAP+L0CG7UD2GAAAAAElFTkSuQmCC',
			'3A91' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7RAMYAhhCGVqRxQKmMIYwOjpMRVHZytrK2hAQiiI2RaTRtSEAphfspJVR01ZmZkYtRXEfUJ1DSEArqnmioQ4N6GIijY5oYgFAvY6ODihiogFA80IZQgMGQfhREWJxHwBH9cydS2aVDQAAAABJRU5ErkJggg==',
			'B96F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7QgMYQxhCGUNDkMQCprC2Mjo6OiCrC2gVaXRtQBObAhJjhImBnRQatXRp6tSVoVlI7guYwhjoimEeA1BvIJoYC6YYFrdA3YwiNlDhR0WIxX0ASRfLWTrgzxsAAAAASUVORK5CYII=',
			'C51F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7WENEQxmmMIaGIImJtIo0MIQwOiCrC2gUaWBEF2sQCQHqhYmBnRS1aurSVdNWhmYhuS+ggaHRYQq6XixijSIYYiKtrK0MaGKsIUCXhDqiiA1U+FERYnEfACULycAtg75BAAAAAElFTkSuQmCC',
			'52E6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QkMYQ1hDHaY6IIkFNLC2sjYwBASgiIk0ujYwOgggiQUGMIDFkN0XNm3V0qWhK1OzkN3XyjCFtYERxTygWABQzEEE2Y5WRgd0MRGgTnS3sAaIhrqiuXmgwo+KEIv7ABV6yyUZjZLzAAAAAElFTkSuQmCC',
			'9C58' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7WAMYQ1lDHaY6IImJTGFtdG1gCAhAEgtoFWlwbWB0EEETY50KVwd20rSp01YtzcyamoXkPlZXkK4AFPMYWkFigSjmCYDtQBUDucXR0QFFL8jNDKEMKG4eqPCjIsTiPgC1lcyECepDMAAAAABJRU5ErkJggg==',
			'3DA0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7RANEQximMLQiiwVMEWllCGWY6oCsslWk0dHRISAAWWyKSKNrQ6CDCJL7VkZNW5m6KjJrGrL7UNXBzXMNxSLWEIBiB8gtrA0BKG4BuRkohuLmgQo/KkIs7gMAqiDNnMhEaaYAAAAASUVORK5CYII=',
			'E60E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QkMYQximMIYGIIkFNLC2MoQyOjCgiIk0Mjo6oos1sDYEwsTATgqNmha2dFVkaBaS+wIaRFuR1MHNc8Ui5ohhB6ZbsLl5oMKPihCL+wB4tMri4f+rRQAAAABJRU5ErkJggg==',
			'50C8' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7QkMYAhhCHaY6IIkFNDCGMDoEBASgiLG2sjYIOoggiQUGiDS6NjDA1IGdFDZt2srUVaumZiG7rxVFHZIYI4p5Aa2YdohMwXQLawCmmwcq/KgIsbgPACCNy//EAxWRAAAAAElFTkSuQmCC',
			'DBAB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QgNEQximMIY6IIkFTBFpZQhldAhAFmsVaXR0dHQQQRVrZW0IhKkDOylq6dSwpasiQ7OQ3IemDm6ea2ggunmNrg1oYlMw9YLcDBRDcfNAhR8VIRb3AQBvyM45E2fgkAAAAABJRU5ErkJggg==',
			'B6A3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7QgMYQximMIQ6IIkFTGFtZQhldAhAFmsVaWR0dGgQQVEn0sDaENAQgOS+0KhpYUtXRS3NQnJfwBTRViR1cPNcQwNQzQOJNaCJAd3C2hCI4haQm4Hmobh5oMKPihCL+wBedc8I4VoUOgAAAABJRU5ErkJggg==',
			'51B3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7QkMYAlhDGUIdkMQCGhgDWBsdHQJQxFgDWIGkCJJYYABQb6NDQwCS+8KmrYpaGrpqaRay+1pR1CHE0MwLwCImMoUBwy1Al4Siu3mgwo+KEIv7AH4gy4e7rFC+AAAAAElFTkSuQmCC',
			'FA0A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7QkMZAhimMLQiiwU0MIYwhDJMdUARY21ldHQICEARE2l0bQh0EEFyX2jUtJWpqyKzpiG5D00dVEw0FCgWGoJmnqOjI5o6kUaHUEZMsSmoYgMVflSEWNwHAIiqzW9pxgYQAAAAAElFTkSuQmCC',
			'255B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7WANEQ1lDHUMdkMREpog0sDYwOgQgiQW0QsREkHW3ioSwToWrg7hp2tSlSzMzQ7OQ3RfA0OjQEIhiHqMDRAzZPNYGkUZXNDGgra2Mjo4oekNDGUMYQhlR3DxQ4UdFiMV9AGxQys8ydnPOAAAAAElFTkSuQmCC',
			'38C9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7RAMYQxhCHaY6IIkFTGFtZXQICAhAVtkq0ujaIOgggiwGVMfawAgTAztpZdTKsKWrVkWFIbsPrI5hqgiGeQwNmGICKHZgcws2Nw9U+FERYnEfAIhVy7olydqbAAAAAElFTkSuQmCC',
			'1B2D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7GB1EQxhCGUMdkMRYHURaGR0dHQKQxEQdRBpdGwIdRFD0irQyIMTATlqZNTVs1crMrGlI7gOra2VE19voMAWLWACGGFAnI6pbQkRDWEMDUdw8UOFHRYjFfQAAusgKO21SdwAAAABJRU5ErkJggg==',
			'1617' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nM2QwQ3AIAhF+Qc30H3oBh6wQ3QKPbiBcYc6Ze0Na49tWjgQXiC8QG2KSH/KV/zAECoIophhk0koWsUc24QLA/euUPTKb9/q2movyg/scp/L412buJzbE/Mj6y4FrJkTCMIysK/+92De+B1RYsg/R5u6NgAAAABJRU5ErkJggg==',
			'81FD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXElEQVR4nGNYhQEaGAYTpIn7WAMYAlhDA0MdkMREpjAGsDYwOgQgiQW0soLFRFDUMSCLgZ20NGpV1NLQlVnTkNyHpg5qHnFiML3IbgG6JBQohuLmgQo/KkIs7gMAd4bIY0FSvEUAAAAASUVORK5CYII=',
			'B4DD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QgMYWllDGUMdkMQCpjBMZW10dAhAFmtlCGVtCHQQQVHH6IokBnZSaNTSpUtXRWZNQ3JfwBSRVgy9raKhrhhiDJjqpgDF0NyCzc0DFX5UhFjcBwBZ6c0sWOWH7wAAAABJRU5ErkJggg==',
			'6F6D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7WANEQx1CGUMdkMREpog0MDo6OgQgiQW0iDSwNjg6iCCLNYDEGGFiYCdFRk0NWzp1ZdY0JPeFAM1jdUTT2wrSG0hQDJtbWAOAKtDcPFDhR0WIxX0AKcnLZSad7loAAAAASUVORK5CYII=',
			'0486' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7GB0YWhlCGaY6IImxBjBMZXR0CAhAEhOZwhDK2hDoIIAkFtDK6Mro6OiA7L6opUuXrgpdmZqF5L6AVpFWoDoU8wJaRUNdgeaJoNrRyoomBnRLK7pbsLl5oMKPihCL+wDzosqF3F068QAAAABJRU5ErkJggg==',
			'198E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7GB0YQxhCGUMDkMRYHVhbGR0dHZDViTqINLo2BDqg6hVpdESoAztpZdbSpVmhK0OzkNwHtCPQEc08RgcGLOaxYBHD4pYQTDcPVPhREWJxHwDGgsccsZt7HQAAAABJRU5ErkJggg==',
			'A806' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7GB0YQximMEx1QBJjDWBtZQhlCAhAEhOZItLo6OjoIIAkFtDK2sraEOiA7L6opSvDlq6KTM1Cch9UHYp5oaEija5AvSIo5kHsEEGzA90tAa2Ybh6o8KMixOI+ANE3zD4jjTVRAAAAAElFTkSuQmCC',
			'CA48' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WEMYAhgaHaY6IImJtDKGMLQ6BAQgiQU0srYyTHV0EEEWaxBpdAiEqwM7KWrVtJWZmVlTs5DcB1Ln2ohmXoNoqGtoIKp5jUDzGlHtEGkFiaHqZQ0Bi6G4eaDCj4oQi/sAv0DOiQlC5eQAAAAASUVORK5CYII=',
			'1119' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7GB0YAhimMEx1QBJjdWAMYAhhCAhAEhN1YA1gDGF0EMHQCxcDO2ll1qqoVdNWRYUhuQ9mB6ZehgYsYljsQHNLCGsoY6gDipsHKvyoCLG4DwCJuMZB1tMEnAAAAABJRU5ErkJggg==',
			'8676' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7WAMYQ1hDA6Y6IImJTGFtZWgICAhAEgtoFWlkaAh0EEBRJ9LA0OjogOy+pVHTwlYtXZmaheQ+kSmirQxTGDHMcwhgdBBBE3N0QBUDuYW1gQFFL9jNDQwobh6o8KMixOI+AAvCy/Kq5zrCAAAAAElFTkSuQmCC',
			'D950' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7QgMYQ1hDHVqRxQKmsLayNjBMdUAWaxVpdG1gCAhAF5vK6CCC5L6opUuXpmZmZk1Dcl9AK2OgQ0MgTB1UjKERU4wFaEcAqh1AtzA6OqC4BeRmhlAGFDcPVPhREWJxHwB9aM4Dl5pBqAAAAABJRU5ErkJggg==',
			'30B1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7RAMYAlhDGVqRxQKmMIawNjpMRVHZytrK2hAQiiI2RaTRtdEBphfspJVR01amhq5aiuI+VHVQ84BiDQGtWOzA5hYUMaibQwMGQfhREWJxHwBQucxe3fXeoAAAAABJRU5ErkJggg==',
			'274F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WANEQx0aHUNDkMREpjA0OrQ6OiCrC2gFik1FFWNoBcJAuBjETdNWTVuZmRmahey+AIYA1kZUvYwOjA6soYEoYqxAyICmTgQI0cVCQzHFBir8qAixuA8As+/J8MVWSwIAAAAASUVORK5CYII=',
			'086F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7GB0YQxhCGUNDkMRYA1hbGR0dHZDViUwRaXRtQBULaGVtZQWagOy+qKUrw5ZOXRmaheQ+sDpHdL0g8wKx2IEqhs0tUDejiA1U+FERYnEfAFrGyRFAyEisAAAAAElFTkSuQmCC',
			'E781' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QkNEQx1CGVqRxQIaGBodHR2moou5NgSEoom1Mjo6wPSCnRQatWraqtBVS5HdB1QXgKQOKsbowNoQgCbG2oApJtKArjc0RKSBIZQhNGAQhB8VIRb3AQBGi80B2VjQggAAAABJRU5ErkJggg==',
			'07BB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7GB1EQ11DGUMdkMRYAxgaXRsdHQKQxESmAMUaAh1EkMQCWhlaWRHqwE6KWrpq2tLQlaFZSO4DqgtgRTMvoJXRgRXNPJEprA3oYqwBIg3oehmBKljR3DxQ4UdFiMV9AIuSy5DyvC/wAAAAAElFTkSuQmCC',
			'6E8B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWklEQVR4nGNYhQEaGAYTpIn7WANEQxlCGUMdkMREpog0MDo6OgQgiQW0iDSwNgQ6iCCLNaCoAzspMmpq2KrQlaFZSO4LwWZeKxbzsIhhcws2Nw9U+FERYnEfAKVJywDYbzISAAAAAElFTkSuQmCC',
			'7072' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdklEQVR4nM2QsQ3DMAwEnwU34EAcgQGkJiNkilehDeRskMKeMiopxKUDmF8QOBDg4XH8DHGn/MWvVoTW2DzTLgWMiIVpBx9umQ1r3pyW/Z7v/fWZK/mJz7uBln8oJwv07GLULo6RWVCKErGy6Uyp5Qb9XZgTvy/8isvWHpmInwAAAABJRU5ErkJggg==',
			'12C3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7GB0YQxhCHUIdkMRYHVhbGR0CHQKQxEQdRBpdGwQaRFD0MgDFGBoCkNy3MmvV0qWrVi3NQnIfUN0UVoQ6mFgASAzVPEYHVgw7WBsw3BIiCnIxipsHKvyoCLG4DwAXKMm0RThvIQAAAABJRU5ErkJggg==',
			'8927' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nM2QsQ2AMAwE3xLZwAOZgt5IpGEEpkiKbOAVUsCUpEwCJQh83RWvk3FcLuBPvNLnlBZ48kvl2FyiUQJXThPHKWjj2DhKcVr15TXnbS9UfWw0S0JCs4coBmvdEEWh6FuEpG92fm7cV/97kJu+ExWEy8p+UUefAAAAAElFTkSuQmCC',
			'2318' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7WANYQximMEx1QBITmSLSyhDCEBCAJBbQytDoGMLoIIKsuxUIp8DVQdw0bVUYEE/NQnZfAIo6MGR0YGh0mIJqHmsDpphIgwiG3tBQ1hDGUAcUNw9U+FERYnEfANJpyzDD+5jsAAAAAElFTkSuQmCC',
			'367E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7RAMYQ1hDA0MDkMQCprC2MjQEOqCobBVpxBCbItLA0OgIEwM7aWXUtLBVS1eGZiG7b4poK8MURgzzHAIwxRwdUMVAbmFtQBUDu7mBEcXNAxV+VIRY3AcATjXJssJmffMAAAAASUVORK5CYII=',
			'2377' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7WANYQ1hDA0NDkMREpoi0MjQENIggiQW0MjQ6oIkxtDJARZHcN21V2Kqlq1ZmIbsvAKhuChAj6WV0AOoMAIoiu6WBodHRAaga2S0NIq2sINVIYqGhQDejiQ1U+FERYnEfAJMMyzrUJitIAAAAAElFTkSuQmCC',
			'EC62' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QkMYQxlCGaY6IIkFNLA2Ojo6BASgiIk0uDY4OoigibECaREk94VGTVu1dOqqVVFI7gOrc3RodMDQG9DKgGFHwBQGLG7BdDNjaMggCD8qQizuAwCfk84aIYMybwAAAABJRU5ErkJggg==',
			'178E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7GB1EQx1CGUMDkMRYHRgaHR0dHZDViQLFXBsCHVD1MrQyItSBnbQya9W0VaErQ7OQ3AdUF8CIZh6jA6MDK4Z5rA2YYiIN6HpFQ0QaGNDcPFDhR0WIxX0Ae6jGwYoOxesAAAAASUVORK5CYII=',
			'0A48' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nGNYhQEaGAYTpIn7GB0YAhgaHaY6IImxBjCGMLQ6BAQgiYlMYW1lmOroIIIkFtAq0ugQCFcHdlLU0mkrMzOzpmYhuQ+kzrUR1byAVtFQ19BAFPNEpgDNa0S1gzUAJIaql9EBLIbi5oEKPypCLO4DAHsvzYkr7uJ8AAAAAElFTkSuQmCC',
			'020F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7GB0YQximMIaGIImxBrC2MoQyOiCrE5ki0ujo6IgiFtDK0OjaEAgTAzspaumqpUtXRYZmIbkPqG4KK0IdTCwAXUxkCtA1aHYA3dKA7hZGB9FQhymoYgMVflSEWNwHACO6yMubrnJdAAAAAElFTkSuQmCC',
			'BE07' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7QgNEQxmmMIaGIIkFTBFpYAhlaBBBFmsVaWB0dEAVA6pjbQgAQoT7QqOmhi1dFbUyC8l9UHWtDGjmAcWmoIsB7QhgwHALowMWN6OIDVT4URFicR8AKyDMvDwLaKUAAAAASUVORK5CYII=',
			'DF5B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QgNEQ11DHUMdkMQCpog0sDYwOgQgi7VCxETQxabC1YGdFLV0atjSzMzQLCT3gdQxNARimAcSwzAPXQzoFkZHRxS9oQFAFaGMKG4eqPCjIsTiPgAisczp+uum3wAAAABJRU5ErkJggg==',
			'D6DF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7QgMYQ1hDGUNDkMQCprC2sjY6OiCrC2gVaWRtCEQXa0ASAzspaum0sKWrIkOzkNwX0CraikVvoysxYljcAnUzithAhR8VIRb3AQAtIcweLuIMxQAAAABJRU5ErkJggg==',
			'9FFD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWUlEQVR4nGNYhQEaGAYTpIn7WANEQ11DA0MdkMREpog0sDYwOgQgiQW0QsREcIuBnTRt6tSwpaErs6YhuY/VFVMvAxbzBLCIYXMLawBYDMXNAxV+VIRY3AcAygHKHx371QcAAAAASUVORK5CYII=',
			'EA1A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QkMYAhimMLQiiwU0MIYwhDBMdUARY20FigYEoIiJNDpMYXQQQXJfaNS0lVkghOQ+NHVQMdFQoFhoCG7zcIqFhog0OoY6oogNVPhREWJxHwDXCczqL8w1IgAAAABJRU5ErkJggg=='        
        );
        $this->text = array_rand( $images );
        return $images[ $this->text ] ;    
    }
    
    function out_processing_gif(){
        $image = dirname(__FILE__) . '/processing.gif';
        $base64_image = "R0lGODlhFAAUALMIAPh2AP+TMsZiALlcAKNOAOp4ANVqAP+PFv///wAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgAIACwAAAAAFAAUAAAEUxDJSau9iBDMtebTMEjehgTBJYqkiaLWOlZvGs8WDO6UIPCHw8TnAwWDEuKPcxQml0Ynj2cwYACAS7VqwWItWyuiUJB4s2AxmWxGg9bl6YQtl0cAACH5BAUKAAgALAEAAQASABIAAAROEMkpx6A4W5upENUmEQT2feFIltMJYivbvhnZ3Z1h4FMQIDodz+cL7nDEn5CH8DGZhcLtcMBEoxkqlXKVIgAAibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkphaA4W5upMdUmDQP2feFIltMJYivbvhnZ3V1R4BNBIDodz+cL7nDEn5CH8DGZAMAtEMBEoxkqlXKVIg4HibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpjaE4W5tpKdUmCQL2feFIltMJYivbvhnZ3R0A4NMwIDodz+cL7nDEn5CH8DGZh8ONQMBEoxkqlXKVIgIBibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpS6E4W5spANUmGQb2feFIltMJYivbvhnZ3d1x4JMgIDodz+cL7nDEn5CH8DGZgcBtMMBEoxkqlXKVIggEibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpAaA4W5vpOdUmFQX2feFIltMJYivbvhnZ3V0Q4JNhIDodz+cL7nDEn5CH8DGZBMJNIMBEoxkqlXKVIgYDibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpz6E4W5tpCNUmAQD2feFIltMJYivbvhnZ3R1B4FNRIDodz+cL7nDEn5CH8DGZg8HNYMBEoxkqlXKVIgQCibbK9YLBYvLtHH5K0J0IACH5BAkKAAgALAEAAQASABIAAAROEMkpQ6A4W5spIdUmHQf2feFIltMJYivbvhnZ3d0w4BMAIDodz+cL7nDEn5CH8DGZAsGtUMBEoxkqlXKVIgwGibbK9YLBYvLtHH5K0J0IADs=";
        $binary = is_file($image) ? join("",file($image)) : base64_decode($base64_image); 
        header("Cache-Control: post-check=0, pre-check=0, max-age=0, no-store, no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: image/gif");
        echo $binary;
    }

}
# end of class phpfmgImage
# ------------------------------------------------------
# end of module : captcha


# module user
# ------------------------------------------------------
function phpfmg_user_isLogin(){
    return ( isset($_SESSION['authenticated']) && true === $_SESSION['authenticated'] );
}


function phpfmg_user_logout(){
    session_destroy();
    header("Location: admin.php");
}

function phpfmg_user_login()
{
    if( phpfmg_user_isLogin() ){
        return true ;
    };
    
    $sErr = "" ;
    if( 'Y' == $_POST['formmail_submit'] ){
        if(
            defined( 'PHPFMG_USER' ) && strtolower(PHPFMG_USER) == strtolower($_POST['Username']) &&
            defined( 'PHPFMG_PW' )   && strtolower(PHPFMG_PW) == strtolower($_POST['Password']) 
        ){
             $_SESSION['authenticated'] = true ;
             return true ;
             
        }else{
            $sErr = 'Login failed. Please try again.';
        }
    };
    
    // show login form 
    phpfmg_admin_header();
?>
<form name="frmFormMail" action="" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:380px;height:260px;">
<fieldset style="padding:18px;" >
<table cellspacing='3' cellpadding='3' border='0' >
	<tr>
		<td class="form_field" valign='top' align='right'>Email :</td>
		<td class="form_text">
            <input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" class='text_box' >
		</td>
	</tr>

	<tr>
		<td class="form_field" valign='top' align='right'>Password :</td>
		<td class="form_text">
            <input type="password" name="Password"  value="" class='text_box'>
		</td>
	</tr>

	<tr><td colspan=3 align='center'>
        <input type='submit' value='Login'><br><br>
        <?php if( $sErr ) echo "<span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
        <a href="admin.php?mod=mail&func=request_password">I forgot my password</a>   
    </td></tr>
</table>
</fieldset>
</div>
<script type="text/javascript">
    document.frmFormMail.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();
}


function phpfmg_mail_request_password(){
    $sErr = '';
    if( $_POST['formmail_submit'] == 'Y' ){
        if( strtoupper(trim($_POST['Username'])) == strtoupper(trim(PHPFMG_USER)) ){
            phpfmg_mail_password();
            exit;
        }else{
            $sErr = "Failed to verify your email.";
        };
    };
    
    $n1 = strpos(PHPFMG_USER,'@');
    $n2 = strrpos(PHPFMG_USER,'.');
    $email = substr(PHPFMG_USER,0,1) . str_repeat('*',$n1-1) . 
            '@' . substr(PHPFMG_USER,$n1+1,1) . str_repeat('*',$n2-$n1-2) . 
            '.' . substr(PHPFMG_USER,$n2+1,1) . str_repeat('*',strlen(PHPFMG_USER)-$n2-2) ;


    phpfmg_admin_header("Request Password of Email Form Admin Panel");
?>
<form name="frmRequestPassword" action="admin.php?mod=mail&func=request_password" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:580px;height:260px;text-align:left;">
<fieldset style="padding:18px;" >
<legend>Request Password</legend>
Enter Email Address <b><?php echo strtoupper($email) ;?></b>:<br />
<input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" style="width:380px;">
<input type='submit' value='Verify'><br>
The password will be sent to this email address. 
<?php if( $sErr ) echo "<br /><br /><span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
</fieldset>
</div>
<script type="text/javascript">
    document.frmRequestPassword.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();    
}


function phpfmg_mail_password(){
    phpfmg_admin_header();
    if( defined( 'PHPFMG_USER' ) && defined( 'PHPFMG_PW' ) ){
        $body = "Here is the password for your form admin panel:\n\nUsername: " . PHPFMG_USER . "\nPassword: " . PHPFMG_PW . "\n\n" ;
        if( 'html' == PHPFMG_MAIL_TYPE )
            $body = nl2br($body);
        mailAttachments( PHPFMG_USER, "Password for Your Form Admin Panel", $body, PHPFMG_USER, 'You', "You <" . PHPFMG_USER . ">" );
        echo "<center>Your password has been sent.<br><br><a href='admin.php'>Click here to login again</a></center>";
    };   
    phpfmg_admin_footer();
}


function phpfmg_writable_check(){
 
    if( is_writable( dirname(PHPFMG_SAVE_FILE) ) && is_writable( dirname(PHPFMG_EMAILS_LOGFILE) )  ){
        return ;
    };
?>
<style type="text/css">
    .fmg_warning{
        background-color: #F4F6E5;
        border: 1px dashed #ff0000;
        padding: 16px;
        color : black;
        margin: 10px;
        line-height: 180%;
        width:80%;
    }
    
    .fmg_warning_title{
        font-weight: bold;
    }

</style>
<br><br>
<div class="fmg_warning">
    <div class="fmg_warning_title">Your form data or email traffic log is NOT saving.</div>
    The form data (<?php echo PHPFMG_SAVE_FILE ?>) and email traffic log (<?php echo PHPFMG_EMAILS_LOGFILE?>) will be created automatically when the form is submitted. 
    However, the script doesn't have writable permission to create those files. In order to save your valuable information, please set the directory to writable.
     If you don't know how to do it, please ask for help from your web Administrator or Technical Support of your hosting company.   
</div>
<br><br>
<?php
}


function phpfmg_log_view(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    
    phpfmg_admin_header();
   
    $file = $files[$n];
    if( is_file($file) ){
        if( 1== $n ){
            echo "<pre>\n";
            echo join("",file($file) );
            echo "</pre>\n";
        }else{
            $man = new phpfmgDataManager();
            $man->displayRecords();
        };
     

    }else{
        echo "<b>No form data found.</b>";
    };
    phpfmg_admin_footer();
}


function phpfmg_log_download(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );

    $file = $files[$n];
    if( is_file($file) ){
        phpfmg_util_download( $file, PHPFMG_SAVE_FILE == $file ? 'form-data.csv' : 'email-traffics.txt', true, 1 ); // skip the first line
    }else{
        phpfmg_admin_header();
        echo "<b>No email traffic log found.</b>";
        phpfmg_admin_footer();
    };

}


function phpfmg_log_delete(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    phpfmg_admin_header();

    $file = $files[$n];
    if( is_file($file) ){
        echo unlink($file) ? "It has been deleted!" : "Failed to delete!" ;
    };
    phpfmg_admin_footer();
}


function phpfmg_util_download($file, $filename='', $toCSV = false, $skipN = 0 ){
    if (!is_file($file)) return false ;

    set_time_limit(0);


    $buffer = "";
    $i = 0 ;
    $fp = @fopen($file, 'rb');
    while( !feof($fp)) { 
        $i ++ ;
        $line = fgets($fp);
        if($i > $skipN){ // skip lines
            if( $toCSV ){ 
              $line = str_replace( chr(0x09), ',', $line );
              $buffer .= phpfmg_data2record( $line, false );
            }else{
                $buffer .= $line;
            };
        }; 
    }; 
    fclose ($fp);
  

    
    /*
        If the Content-Length is NOT THE SAME SIZE as the real conent output, Windows+IIS might be hung!!
    */
    $len = strlen($buffer);
    $filename = basename( '' == $filename ? $file : $filename );
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        case "mp3": $ctype="audio/mpeg"; break;
        case "wav": $ctype="audio/x-wav"; break;
        case "mpeg":
        case "mpg":
        case "mpe": $ctype="video/mpeg"; break;
        case "mov": $ctype="video/quicktime"; break;
        case "avi": $ctype="video/x-msvideo"; break;
        //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        case "php":
        case "htm":
        case "html": 
                $ctype="text/plain"; break;
        default: 
            $ctype="application/x-download";
    }
                                            

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");
    //Force the download
    header("Content-Disposition: attachment; filename=".$filename.";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    
    while (@ob_end_clean()); // no output buffering !
    flush();
    echo $buffer ;
    
    return true;
 
    
}
?>