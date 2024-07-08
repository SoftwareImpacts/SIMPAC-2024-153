<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
textarea {
  resize: none;
}
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0 0 50px;
            color: #333;
            font-size: 14px;
        }
      
        pre {
            padding: 20px 20px 0 0;
            background: #f9f9f9;
            border: 1px solid #f2f2f2;
            margin-bottom: 30px;
            line-height: 2em;
        }
 
        .container {
            width: 80%;
            margin: 60px auto;
        }
        .slider-container {
            width: 90%;
            max-width: 500px;
            margin: 0 auto 20px;
        }
        .config {
            border: 1px solid #f2f2f2;
            margin-bottom: 30px;
            line-height: 1.7em;
        }
        .config table {
            border-collapse: collapse;
            width: 100%;
        }
        .config table td {
            padding: 10px;
            border-bottom: 1px solid #f2f2f2;
        }
        .label {
            font-weight: bold;
            white-space: nowrap;
        }        
		p.test {
    		width: 600px; 
   		 	word-wrap: break-word;
		}
		.style1 {color: #123}

		.border {
  			border: thin solid;
  			border-color: #919191;
		}
		
		.top {
  			border-top: thin solid;
  			border-color: #919191;
		}

		.bottom {
  			border-bottom: thin solid;
  			border-color: #919191;
		}

		.left {
  			border-left: thin solid;
  			border-color: #919191;
		}

		.right {
  			border-right: thin solid;
  			border-color: #919191;
		}
		
		.ash{
			border-color: #d8d8d8;
		}
		
		.tmhig { color: #06ac60;}
		.tmave { color: #d70f12;}
		.tmlow { color: #156ea6;}
    </style>
    <link rel="stylesheet" href="css/rSlider.min.css">
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->
<link href="css/bootstrap-3.3.6.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link rel="icon" href="img3.png" type="image/x-icon">
<title>HRM Design Tool</title>
<script language="javascript">
function atgcOnly(ob) {
  var invalidChars = /[^a,t,g,c,A,T,G,C]/gi
  if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
      }
}
</script>
<script src="js/rSlider.min.js"></script>
    <script>	
        (function () {
            'use strict';

            var init = function () {                
                var Tmslider3 = new rSlider({
                    target: '#Tmslider',
                    values: {min: 40, max: 80},
                    step: 1,
                    range: true,
                    set: [<?php if($_POST==null){ echo "50, 80";} else{
						$tmarray1 = explode(",",$_POST["Tmslider"]);
						echo $tmarray1[0].",".$tmarray1[1];}?>],
                    scale: false,
					labels: false,
                    onChange: function (vals) {
                        console.log(vals);
                    }
                });

                 var GCslider = new rSlider({
                    target: '#GCslider',
                    values: {min: 20, max: 80},
                    step: 5,
                    range: true,
                    set: [<?php if($_POST==null){ echo "30, 70";} else{
						$gcarray1 = explode(",",$_POST["GCslider"]);
						echo $gcarray1[0].",".$gcarray1[1];}?>],
                    scale: true,
                    labels: false,
                    onChange: function (vals) {
                        console.log(vals);
                    }
                });
            };
            window.onload = init;
        })();
    </script>
<?php
function CountCG($c){
        $cg=substr_count($c,"G")+substr_count($c,"C");
        return $cg;
        }
		
function CountATCG($c){
        $cg=substr_count($c,"A")+substr_count($c,"T")+substr_count($c,"G")+substr_count($c,"C");
        return $cg;
        }
	
function GCcontent($primer){		
		$cg=round(100*CountCG($primer)/strlen($primer),1);
		return $cg;
        }

//*************************************//
function avgGC($fprimer,$rprimer){		
		$gc1 = GCcontent($fprimer);
		$gc2 = GCcontent($rprimer);
		
		$avgGC = ($gc1+$gc2)/2;
		return $avgGC;
	}
//***********************************//

function Complement($seq){
        // change the sequence to upper case
        $seq = strtoupper ($seq);
        // the system used to get the complementary sequence is simple but fas
        $seq=str_replace("A", "t", $seq);
        $seq=str_replace("T", "a", $seq);
        $seq=str_replace("G", "c", $seq);
        $seq=str_replace("C", "g", $seq);
        
        // change the sequence to upper case again for output
        $seq = strtoupper ($seq);
        return $seq;
}

function rcom($seq){
	// reverse the sequence
    $seq=strrev($seq);
    // get the complementary sequence
    $seq=Complement($seq);
	return $seq;
	}
		
function tm_Base_Stacking($c,$conc_primer,$conc_salt,$conc_mg){

        if (CountATCG($c)!= strlen($c)){print "The oligonucleotide is not valid";return;}
        $h=$s=0;
        // from table at http://www.ncbi.nlm.nih.gov/pmc/articles/PMC19045/table/T2/ (SantaLucia, 1998)
        // enthalpy values
        $array_h["AA"]= -7.9;
        $array_h["AC"]= -8.4;
        $array_h["AG"]= -7.8;
        $array_h["AT"]= -7.2;
        $array_h["CA"]= -8.5;
        $array_h["CC"]= -8.0;
        $array_h["CG"]=-10.6;
        $array_h["CT"]= -7.8;
        $array_h["GA"]= -8.2;
        $array_h["GC"]= -9.8;
        $array_h["GG"]= -8.0;
        $array_h["GT"]= -8.4;
        $array_h["TA"]= -7.2;
        $array_h["TC"]= -8.2;
        $array_h["TG"]= -8.5;
        $array_h["TT"]= -7.9;
        // entropy values
        $array_s["AA"]=-22.2;
        $array_s["AC"]=-22.4;
        $array_s["AG"]=-21.0;
        $array_s["AT"]=-20.4;
        $array_s["CA"]=-22.7;
        $array_s["CC"]=-19.9;
        $array_s["CG"]=-27.2;
        $array_s["CT"]=-21.0;
        $array_s["GA"]=-22.2;
        $array_s["GC"]=-24.4;
        $array_s["GG"]=-19.9;
        $array_s["GT"]=-22.4;
        $array_s["TA"]=-21.3;
        $array_s["TC"]=-22.2;
        $array_s["TG"]=-22.7;
        $array_s["TT"]=-22.2;

        // effect on entropy by salt correction; von Ahsen et al 1999
                // Increase of stability due to presence of Mg;
                $salt_effect= ($conc_salt/1000)+(($conc_mg/1000) * 140);
                // effect on entropy
                $s+=0.368 * (strlen($c)-1)* log($salt_effect);

        // terminal corrections. Santalucia 1998
                $firstnucleotide=substr($c,0,1);
                if ($firstnucleotide=="G" or $firstnucleotide=="C"){$h+=0.1; $s+=-2.8;}
                if ($firstnucleotide=="A" or $firstnucleotide=="T"){$h+=2.3; $s+=4.1;}

                $lastnucleotide=substr($c,strlen($c)-1,1);
                if ($lastnucleotide=="G" or $lastnucleotide=="C"){$h+=0.1; $s+=-2.8;}
                if ($lastnucleotide=="A" or $lastnucleotide=="T"){$h+=2.3; $s+=4.1;}

        // compute new H and s based on sequence. Santalucia 1998
        for($i=0; $i<strlen($c)-1; $i++){
                $subc=substr($c,$i,2);
                $h+=$array_h[$subc];
                $s+=$array_s[$subc];
        }
        $tm=((1000*$h)/($s+(1.987*log($conc_primer/2000000000))))-273.15;
        $tm = round($tm,1);
		return $tm;
       // print  "\n<font color=008800>  Enthalpy: ".round($h,2)."\n  Entropy:  ".round($s,2)."</font>";
}

function GCcloseto50($fprimer,$rprimer){
	$gc1 = GCcontent($fprimer);
	$gc2 = GCcontent($rprimer);
		
	$dif1 = 2*$gc1-100;		if($dif1<0){$dif1=0-$dif1;}
	$dif2 = 2*$gc2-100;		if($dif2<0){$dif2=0-$dif2;}
	
	if(min($dif1,$dif2)==$dif1){
		return $fprimer;
		}else{ 
		return $rprimer;
		} 
	}
	
function tmmin($primer1,$primer2,$mgcon){
		$tm1=tm_Base_Stacking($primer1,200,50,$mgcon);
		$tm2=tm_Base_Stacking($primer2,200,50,$mgcon);
		if(min($tm1,$tm2)==$tm1){
		return $primer1;
		}else{
		return $primer2;
		}
	}

	function tminc($primer){
	$arr1=str_split($primer);
		if($arr1[0]=="C"){	$primer="GCG".$primer;		}
		else{$primer="TGC".$primer;		}
		return $primer;
	}

	function tmred($primer){
	$arr1=str_split($primer);
		if($arr1[0]=="A"){		$primer="TAT".$primer;		}
		else{		$primer="CTA".$primer;			}
		return $primer;
	}

?>
</head>
<body>
<ul class="nav nav-tabs">
  <li role="presentation" ><a href="index.php"><div align="center" style="font-size: 14px; alignment-baseline:middle">SNPgen<sup>®</sup> Home</div></a></li>
  <li role="presentation" ><a href="SNPinfo.php">SNP info</a></li>
  <li role="presentation"><a href="arms.php">ARMS-PCR design</a></li>
  <li role="presentation"><a href="hrm.php">HRM Assay Design (dbSNP)</a></li>
  <li role="presentation"><a href="hrm-m.php">HRM Assay Design</a></li>
  <li role="presentation" class="active"><a href="hrm-indel.php">HRM Assay Design(Indel)</a></li>
</ul>
<br>
<table width="950px" Cellspacing="20" border="0" bgcolor="#D8D8D8" cellpadding="80" align="center" class="ash">
  <tbody>
    <tr bgcolor="#D8D8D8">
	<td width="12px" bgcolor="#D9D9D9"></td>
		<td colspan="12" width="950" align="center">
	  <br><span style="text-align: center"><img src="untitled.png" width="134" height="71"></span>
	  <br>
	  <h1>High  Resolution Melt (HRM) – Oligo Design Tool</h1></td>
	  <td width="12px" bgcolor="#D9D9D9"></td>
    </tr>
    <tr><td width="12px" bgcolor="#D9D9D9"></td>
    <form method="post" name="form1" action="">
	    <td colspan="5" rowspan="2" width="400px" align="center" bgcolor="#D9D9D9" class="top left right bottom">
		<strong>Upstream Sequence (5'>3') - Max:100 bases</strong>
		<br><textarea name="up" id="up" cols="57" rows="5" maxlength="120" id="textarea" onkeyup="atgcOnly(this)" required><?php if($_POST!=null){ echo strtoupper($_POST['up']);} ?></textarea></td>
		<td colspan="2" rowspan="1" width="150px" align="center" bgcolor="#D9D9D9" class="top left right bottom">
		<strong><abbr title="Inserted/Deleted Sequence">Indel Sequence<br>(Max:20 bases)</abbr></strong>		<br>
		<input type="text" name="indel" id="indel" maxlength="20" title="INDEL Sequence" value="<?php if($_POST!=null){echo strtoupper($_POST['indel']);}?>" onkeyup="atgcOnly(this)" required>
		<br>
		<td colspan="5" rowspan="2" width="400px" align="center" bgcolor="#D9D9D9" class="top left right bottom"><strong>Downstream Sequence (5'>3') - Max:100 bases</strong>
		<br><textarea name="do" id="do" cols="57" rows="5" maxlength="120" id="textarea" onkeyup="atgcOnly(this)" required><?php if($_POST!=null){ echo strtoupper($_POST['do']);} ?></textarea></td>
	<td width="12px" bgcolor="#D9D9D9"></td></tr>
	<tr><td width="12px" bgcolor="#D9D9D9"></td>
	<td colspan="2" width="auto" bgcolor="#D9D9D9" align="center" class="top left right bottom">
        <strong><abbr title="Magnesium Ion Concentration">[Mg<sup>2+</sup>]</abbr><br>
        <?php if($_POST==null){ ?>
        <input name="Mgslider" type="number" min="1.0" max="3.0" step="0.5" value="2.5" size="4"/>
        <?php }else{?>
        <input name="Mgslider" type="number" min="1.0" max="3.0" step="0.5" size="4" value="<?php echo $_POST['Mgslider']; ?>"/>
        <?php } ?>
        <abbr title="mol/ml">mM</abbr></strong>
        </td>
	<td width="12px" bgcolor="#D9D9D9"></td></tr>
	<tr><td width="12px" bgcolor="#D9D9D9"></td>
        <td valign="middle" height="30" align="right" bgcolor="#D9D9D9" width="40"><strong><abbr title="GC Content"> GC%: </abbr></strong></td>
        <td align="center" valign="bottom" height="100px" width="330px" bgcolor="#D9D9D9" colspan="4">
        <div class="slider-container">
            		<input type="text" id="GCslider" class="slider" name="GCslider"/>
        		</div>
        </td>
		<td colspan="2" width="84" bgcolor="#D9D9D9" align="center" class="top left right bottom">
			<strong><input name="submit" type="submit" id="submit" formmethod="post" title="design" value="DESIGN" width="auto"></strong>
			<br> <br>
			<strong><a href="hrm-m.php">CLEAR</a><strong>
		</td>
      
        <td valign="middle" height="30" align="right" bgcolor="#D9D9D9" width="40"><strong><abbr title="Melting Temperature">Tm(<sup>0</sup>C):</abbr></strong></td>
        <td align="center" valign="bottom" height="100px" width="330px" bgcolor="#D9D9D9" colspan="4">
        <div class="slider-container">       
                          <input type="text" id="Tmslider" class="slider" name="Tmslider"/>
                   </div>
        </td>      
    <td width="12px" bgcolor="#D9D9D9"></td></tr>
    </form>
    <?php 
	if(isset($_POST['submit'])){
	$gcarray = explode(",",$_POST["GCslider"]);
	$gcmin = $gcarray[0];	$gcmax = $gcarray[1];
	$tmarray = explode(",",$_POST["Tmslider"]);
	$Tmin = $tmarray[0]; 	$Tmax = $tmarray[1]; $mgcon = $_POST['Mgslider'];
	$indel = strtoupper($_POST['indel']);
	$up2 ="CTATGTCTCTAAATTTGGTTGCTTTCAGAGAATCTCTCCTCTGTCTCCCTATTGCAGGTCTCTAAAAATAGCAAAGACTGGTAAAGAGCTTTATACTTTTACCAGATGGTATCTCACTGAACCCCCAAACAGACCTGTAACATTTTTAGGAGGGTTATTACCCATTTGATAAAAGGAAGAAATTAGGAAAGGCTAATCAACTTGCTCAACACATCCAATACCAACAGACCTGGAATTTGAAACTAAGACAAAATATGTTATCACACTCTAGACTTGCCTTCGGCAGTGATGGTACTGATAAAAATAGACAAGACAAAAAAAAAAAAAGAATAAATGTTATCACACTGGTGCTAAAAAGGACTACTTGACA";
	$do2 ="GTGGGTTCATCAAACTCTAAGATGTTCCACTTATAAGTATAGGTTTCCCCTGGTTGAACTGCTCTGATCATGGTGTTGTTCCTGCCTGAAAGAAAATATATTCAAAATTGTTTTCATTTGCAAAGTTATTTCATGATAATAAATAAATAAATAAGCTTTCGCTGGAACCAATTAATATTGCAAAAGGAATTCTTTTATTTTTATTTTTTTTAAATTATACTTTAAGTTCTAGGGTACATGTGCACAACGTGCAGGTTTGTTACATATGTATACATGTGTCATGTTGGTGTGCTGCACCCATTAACTTGTCATTAACATTAGGTATATCTCCTAATGCTATCCCT";
	$up = $up2.strtoupper($_POST['up']);
	$do = strtoupper($_POST['do']).$do2;
	$indellen = strlen($indel);
	$pos1 = strlen($up)+1;
	$url= "https://primer1.soton.ac.uk/cgi-bin/runprimer1.cgi?".$up."G".$do."+".$pos1."+G+C+27+30+24+200+300+100+1.5+1.1+65+".$Tmax."+".$Tmin."+".$gcmax."+".$gcmin."+8.00+3.00+50+50+1";
?>
<tr>
<td width="12px" bgcolor="#D9D9D9">
<td colspan="12">
<?php
	$home= file_get_contents($url);
	$ele=explode("\n",$home);
	if ($ele[2] != "******************************OUTPUT 1******************************"){
		echo $home;	
		exit; }
	else{
	$lyne1=explode(" ",$ele[4]);
	$fprimer = $lyne1[1];
	$lyne2=explode(" ",$ele[7]);
	$rprimer = $lyne2[1];
	$indelspecificori;
	
	if($indellen==1){
		if((substr($up,-1,1)==$indel)&&(substr($do,0,1)==$indel)){
			echo "Error: Insertion / Deletion is in the middle of a triplet</td><td></td></tr>";
			exit();
		}elseif(substr($up,-1,1)==$indel){
			$indelspecificori = "FW";
		}elseif(substr($do,0,1)==$indel){
			$indelspecificori = "RW";
		}else{
			if(GCcloseto50($fprimer,$rprimer)==$fprimer){
				$indelspecificori = "FW";
			}else{
				$indelspecificori = "RW";
		}
	}
	//dofirst and indel first same
	}elseif((substr($do,0,1)==substr($indel,0,1))&&(substr($up,-1,1)==substr($indel,-1,1))){
		echo "Error: Insertion / Deletion have identical nucleotides at the terminus</td><td></td></tr>";
		exit();
	}elseif(substr($do,0,1)==substr($indel,0,1)){
		$indelspecificori = "RW";
	//uplast and indel last same
	}elseif(substr($up,-1,1)==substr($indel,-1,1)){
		$indelspecificori = "FW";
	}else{
		if(GCcloseto50($fprimer,$rprimer)==$fprimer){
			$indelspecificori = "FW";
		}else{
			$indelspecificori = "RW";
		}
	}
	
	if($indelspecificori == "FW"){
		$ori="FW"; $cpori="RW";
		$isp = tminc(substr($fprimer,0,-1).substr($indel,0,1));
		$dsp = tmred(substr($fprimer,0,-1).substr($do,0,1));
		$asplow = $dsp;
		$asphigh = $isp;
	
		$cplen = strlen($rprimer);
		$cplen2 = strlen($fprimer);
		$cp = rcom(substr($do,1,$cplen));
		$tar = array(substr($up,strlen($up)-($cplen2-1),strlen($up)),substr($do,0,1),rcom($cp));
	
	}elseif($indelspecificori == "RW"){	
		$ori="RW"; $cpori="FW";
		$insall = Complement(substr($indel,-1,1));
		$delall = Complement(substr($up,-1,1));
		$isp = tminc(substr($rprimer,0,-1).$insall);
		$dsp = tmred(substr($rprimer,0,-1).$delall);
		$asplow = $dsp;
		$asphigh = $isp;
			
		$cplen = strlen($fprimer);
		$cplen2 = strlen($rprimer);
		$cp = strtoupper(substr($up,strlen($up)-(($cplen)+1),-1));
		$tar = array($cp,substr($up,-1,1),strtoupper(substr($do,0,$cplen-1)));
	}	
$ale1=str_split($asplow);		
$alow = $ale1[strlen($asplow)-1];
$ale2=str_split($asphigh);
$ahig = $ale2[strlen($asphigh)-1];

//echo $asplow.tm_Base_Stacking($asplow,200,50,$mgcon)."<br>";
//echo $asphigh.tm_Base_Stacking($asphigh,200,50,$mgcon)."<br>";
//echo $tar[0]."-".$tar[1];

}
?>
</td><td width="12" bgcolor="#D9D9D9">
</tr>

    <tr><td width="12px" bgcolor="#D9D9D9">
      <td bgcolor="#D9D9D9" height="40px" valign="middle" colspan="3"><font size="+1"><strong>Output:</strong></font></td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="59" bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td width="75" bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
    <td width="12px" bgcolor="#D9D9D9"></tr>
    
    <tr><td width="12px" bgcolor="#D9D9D9">
      <td bgcolor="#D9D9D9" colspan="2"><strong><abbr title="Deletion Specific Primer">DEL-<?php echo $ori; ?>:</abbr>:</strong>
	  <strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($asplow)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($asplow)."% "; ?></td>
      <td bgcolor="#D9D9D9" align="left"><strong><abbr title="Melting Temperature">Tm</abbr>:</strong>
	  <?php echo tm_Base_Stacking($asplow,200,50,$mgcon)."<sup>o</sup>C "; ?>
      </td>
      <td bgcolor="#D9D9D9" colspan="2" width="500"><strong> | <abbr title="Insertion Specific Primer">INS-<?php echo $ori; ?>:</abbr>:</strong>
	  <strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($asphigh)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($asphigh)."% "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="Melting Temperature">Tm</abbr>:</strong><?php echo tm_Base_Stacking($asphigh,200,50,$mgcon)."<sup>o</sup>C "; ?></td>
      <td bgcolor="#D9D9D9"><strong><font color="#D9D9D9">.</font>| <abbr title="Common Primer:Direction">Common:</strong><?php
	  echo $cpori;?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($cp)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($cp)."% "; ?></td>
      <td bgcolor="#D9D9D9"><strong><strong><abbr title="Melting Temperature">Tm</abbr>:</strong><?php echo tm_Base_Stacking($cp,200,50,$mgcon)."<sup>o</sup>C"; ?></td>
    <td width="12px" bgcolor="#D9D9D9"></tr>
    
    <tr height="40"><td width="12px" bgcolor="#D9D9D9">
      <td bgcolor="#D9D9D9" colspan="4" align="center" valign="top" width="400">
      <table width="90%" border="1"><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo substr($asplow,0,strlen($asplow)-1)."<span class='tmlow'><strong>".$alow."</strong></span>"; ?></td>
          </tr></table></td>
      <td bgcolor="#D9D9D9" colspan="4" align="center" valign="top" width="400">
            <table width="90%" border="1"><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo substr($asphigh,0,strlen($asphigh)-1)."<span class='tmhig'><strong>".$ahig."</strong></span>"; ?></td>
          </tr></table></td>
      <td bgcolor="#D9D9D9" colspan="4" align="center" valign="top" width="400">
            <table width="90%" border="1"><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo $cp; ?></td>
          </tr></table></td>
    <td width="12px" bgcolor="#D9D9D9"></tr>
    
    <tr><td width="12px" bgcolor="#D9D9D9">
      <td bgcolor="#D9D9D9" colspan="5"><strong>Amplicon Size:</strong><?php echo strlen($tar[0].$tar[1].$tar[2]); ?>bp/<?php echo strlen($tar[0].$tar[1].$tar[2].$indel); ?>bp</td>
	<td bgcolor="#D9D9D9" colspan="3" align="center"></td></td>
      <td bgcolor="#D9D9D9"><abbr title="Melting Temperature"><strong>Tm(<sup>o</sup>C)</strong></abbr></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmlow'><strong><abbr title='Homozygous Allele 1 (Low Tm)'>-/-</abbr></strong></span>"; ?></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmave'><strong><abbr title='Heterozygous'>-/".$indel."</abbr></strong></span>"; ?></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmhig'><strong><abbr title='Homozygous Allele 2 (High Tm)'>".$indel."/".$indel."</abbr></strong></span>"; ?></td>
    <td width="12px" bgcolor="#D9D9D9"></tr>
    <tr><td width="12px" bgcolor="#D9D9D9">
      <td height="50" colspan="8" align="center" bgcolor="#D9D9D9" valign="top">
      		<table width="650" border="1"><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php 
			if($ori=="RW"){
			echo rcom($tar[2])."[<span class='tmlow'><strong>-</strong></span>/"."<span class='tmhig'><strong>".rcom($indel)."</strong></span>]".rcom($tar[1]).rcom($tar[0]);
			}else{
			echo $tar[0]."[<span class='tmlow'><strong>-</strong></span>"."/<span class='tmhig'><strong>".$indel."</strong></span>]".$tar[1].$tar[2];	
			}
			?></td>
          </tr></table></td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9" valign="top" align="center">
      		<table width="50" border="1" align="center" ><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo tm_Base_Stacking(($asplow.$cp),200,50,$mgcon); ?></td>
          </tr></table>
      </td>
      <td bgcolor="#D9D9D9" valign="top" align="center">
      		<table width="50" border="1" align="center" ><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo round((tm_Base_Stacking(($asplow.$cp),200,50,$mgcon)+tm_Base_Stacking(($asphigh.$indel.$cp),200,50,$mgcon))/2,1); ?></td>
          </tr></table>
      </td>
      <td bgcolor="#D9D9D9" valign="top" align="center">
      		<table width="50" border="1" align="center" ><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo tm_Base_Stacking(($asphigh.$indel.$cp),200,50,$mgcon); ?></td>
          </tr></table>
      </td>
   
    <td width="12px" bgcolor="#D9D9D9"></tr>
   
    <tr><td width="12px" bgcolor="#D9D9D9">
      <td colspan="4" bgcolor="#D9D9D9" align="right"><img src="untitled2.png" width="332" height="243"></td>
      <td colspan="4" bgcolor="#D9D9D9" align="center"><img src="untitled3.png" width="333" height="241"></td>
      <td colspan="4" bgcolor="#D9D9D9" align="left"><img src="untitled4.png" width="337" height="242"></td>
    <td width="12px" bgcolor="#D9D9D9"></tr>
     <?php
}
	
?>
  </tbody>
</table>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:2, validateOn:["blur", "change"], minValue:2});
//-->
</script>
<footer><br>
  <p align="center">Designed by : <a href="mailto:kajan.muneeswaran@gmail.com">M. Kajan </a> for <a href="https://www.facebook.com/BioTech.edu.lk/">Biotechnology Forum Sri Lanka</a> </p>
</footer>
</body>
</html>