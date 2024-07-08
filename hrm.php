<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
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
  <li role="presentation" class="active"><a href="hrm.php">HRM Assay Design (dbSNP)</a></li>
  <li role="presentation"><a href="hrm-m.php">HRM Assay Design</a></li>
  <li role="presentation"><a href="hrm-indel.php">HRM Assay Design(Indel)</a></li>
</ul>
<br>
<table width="1032px" border="0" bgcolor="#D8D8D8" cellpadding="8" align="center">
  <tbody>
    <tr bgcolor="#D8D8D8">
      <td width="143" height="84" valign="middle" align="center"><span style="text-align: center"><img src="untitled.png" width="134" height="71"></span></td>
      <td colspan="11" align="center"><h1>High  Resolution Melt (HRM) – Oligo Design Tool</h1></td>
    </tr>
    <tr>
    <form method="get" name="form1" action="">
      <td rowspan="2" align="center" bgcolor="#D9D9D9"><strong>Enter dbSNP ID:<br>(rs#)</strong></td>
      <td colspan="2" rowspan="2" width="400px" align="center" bgcolor="#D9D9D9"><strong>rs<span id="sprytextfield1">
      
      <?php
	  	if($_GET==null){
			?>
			 <input name="snpid" type="text" required="required" class="style1" id="snpid" onfocus="this.value=''" value="6025" size="8" maxlength="10">
            <?php
		}else{?>
			<input name="snpid" type="text" required="required" class="style1" id="snpid" onfocus="this.value=''" value="<?php echo $_GET['snpid']; ?>" size="8" maxlength="10">
		<?php	}
	  ?>
      
     
      <span class="textfieldRequiredMsg"><br>A value is required.</span><span class="textfieldInvalidFormatMsg"><br>Invalid format.</span><span class="textfieldMinCharsMsg"><br>Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg"><br>Exceeded maximum number of characters.</span></span></strong></td>
      <td width="64" rowspan="2" bgcolor="#D9D9D9"> <strong><input name="search" type="submit" id="search" formmethod="GET" title="search" value="Search" ></strong></td></form>
      <?php
//Get value from user input
if(isset($_GET["search"])){
	$snp=$_GET["snpid"];
	//ncbi db query using user input dbSNP in XML format
	$surl="https://api.ncbi.nlm.nih.gov/variation/v0/beta/refsnp/".$snp;
	$json_string = file_get_contents($surl);
	if(json_decode($json_string, TRUE)==true) {
    $json_array=json_decode($json_string, TRUE);
	$snpid = $json_array["refsnp_id"];}else {
		 echo "<h2 align='center'>Error: SNP ID Not Found</h2>";
	}	
	
	//Loading variables Chrmosome and position with gene
	$allele1 = $json_array["primary_snapshot_data"]["allele_annotations"]["1"]["frequency"]["0"]["observation"]["deleted_sequence"];
	$allele2 = $json_array["primary_snapshot_data"]["allele_annotations"]["1"]["frequency"]["0"]["observation"]["inserted_sequence"];
	if($allele1=$allele2){
		$allele2 = $json_array["primary_snapshot_data"]["allele_annotations"]["0"]["frequency"]["0"]["observation"]["inserted_sequence"];
	}
	$gene = $json_array["primary_snapshot_data"]["allele_annotations"]["0"]["assembly_annotation"]["0"]["genes"]["0"]["locus"];
	$position = $json_array["primary_snapshot_data"]["anchor"];
	$elem=explode(":",$position);
	$pos = $elem[1]+1;
	$accno = $elem[0];
	$type = strtoupper($elem[3]);
	$uppos = $elem[1]-499;
	$dopos = $elem[1]+500;
	$ch = preg_replace('/[^0-9]/i', '',$elem[0]);
	$ch = (int)substr($ch, 0, -2);
	
	//Genebank sequence retrival 
	$giurl = file_get_contents("https://www.ncbi.nlm.nih.gov/nuccore/".$accno."?report=fasta_xml&log$=seqview&format=text&from=".$uppos."&to=".$dopos);
	$giele = explode(":",$giurl);
	$gino = preg_replace("/[^0-9]/", "", $giele[2]);
	
	$xurl= "https://www.ncbi.nlm.nih.gov/sviewer/viewer.cgi?tool=portal&save=file&log$=seqview&db=nuccore&report=fasta_xml&id=$gino&from=$uppos&to=$dopos&";
	copy($xurl,"sequence.xml");
	$url="sequence.xml";
	$seq = null;
	if (simplexml_load_file($url,"SimpleXMLElement", LIBXML_NOCDATA)==false){  
	echo "<h2 align='center'>Error: Unable to Connect to NCBI</h2>"; 
	}else{
	$xml=simplexml_load_file($url,null, LIBXML_NOCDATA) ; 
	$seq=$xml->TSeq->TSeq_sequence; }
	?>
    <form method="post" name="form2" action="">
    	<td colspan="12" height="40" width="700px" bgcolor="#D9D9D9" class="top left right"></td></tr><tr>
        <td colspan="12" width="700px" bgcolor="#D9D9D9" class="left right bottom">
        <table width="700px" bgcolor="#D9D9D9" align="center">
       
        <td valign="top" height="30" align="left" bgcolor="#D9D9D9" width="40"><strong><abbr title="GC Content"> GC%:</abbr></strong></td>
        <td align="center" valign="bottom" width="300px" bgcolor="#D9D9D9">
        <div class="slider-container">
            		<input type="text" id="GCslider" class="slider" name="GCslider"/>
        		</div>
        </td>
        <td valign="top" height="30" align="left" bgcolor="#D9D9D9" width="40"><strong><abbr title="Melting Temperature">Tm(<sup>0</sup>C):</abbr></strong></td>
        <td align="center" valign="bottom" width="300px" bgcolor="#D9D9D9">
        <div class="slider-container">       
                          <input type="text" id="Tmslider" class="slider" name="Tmslider"/>
                   </div>
        </td>
        <td bgcolor="#D9D9D9" width="10px"></td>
        </table>
        </td>
    	</tr>    
    <tr>
    <td bgcolor="#D9D9D9" ></td>
    <td width="auto" bgcolor="#D9D9D9" height="36" align="center"><strong>
<?php
    $msi="SNPinfo.php?search=Search&snpid=".$snp;
  echo "<a href='$msi' target='_blank'>>SNP_info</a>";
  ?></strong>
    </td>
      <td width="auto" height="36" colspan="2" bgcolor="#D9D9D9" align="center"><strong><?php 
  $ncbi="https://www.ncbi.nlm.nih.gov/SNP/snp_ref.cgi?type=rs&rs=".$snp;
  echo "<a href='$ncbi' target='_blank'>dbSNP</a>" ?></strong></td>
      <td colspan="2" width="auto" bgcolor="#D9D9D9" class="left bottom"><div align="center" class="style2"><strong>Allele 1 :
            <select name="a1" id="a1">
    <?php 
		echo "<option value=$allele1>".$allele1."</option>";
		echo "<option value=$allele2>".$allele2."</option>";
	?>
    </select>
      </strong></div></td>
      <td colspan="2" width="auto" bgcolor="#D9D9D9" class="bottom"><div align="center" class="style2"><strong>Allele 2 :
            <select name="a2" id="a2">
		<?php 
			echo "<option value=$allele2>".$allele2."</option>";
			echo "<option value=$allele1>".$allele1."</option>";
		?>
    </select>
      </strong></div></td>
      <td colspan="3" width="auto" bgcolor="#D9D9D9" align="center" class="left right bottom">
        <strong><abbr title="Magnesium Ion Concentration">[Mg<sup>2+</sup>]:</abbr>
        <?php if($_POST==null){ ?>
        <input name="Mgslider" type="number" min="1.0" max="3.0" step="0.5" value="2.5" size="4"/>
        <?php }else{?>
        <input name="Mgslider" type="number" min="1.0" max="3.0" step="0.5" size="4" value="<?php echo $_POST['Mgslider']; ?>"/>
        <?php } ?>
        <abbr title="mol/ml">mM</abbr></strong>
        </td>
      <td width="84" bgcolor="#D9D9D9" align="center"><strong><input name="submit" type="submit" id="submit" formmethod="post" title="design" value="DESIGN" width="auto"></strong></td>
      
    </tr>
    </form>
    <?php 
	if(isset($_POST['submit'])){
	$a1 = $_POST['a1'];	$a2 = $_POST['a2'];
	$gcarray = explode(",",$_POST["GCslider"]);
	$gcmin = $gcarray[0];	$gcmax = $gcarray[1];
	$tmarray = explode(",",$_POST["Tmslider"]);
	$Tmin = $tmarray[0]; 	$Tmax = $tmarray[1]; $mgcon = $_POST['Mgslider'];
	$up2 ="CTATGTCTCTAAATTTGGTTGCTTTCAGAGAATCTCTCCTCTGTCTCCCTATTGCAGGTCTCTAAAAATAGCAAAGACTGGTAAAGAGCTTTATACTTTTACCAGATGGTATCTCACTGAACCCCCAAACAGACCTGTAACATTTTTAGGAGGGTTATTACCCATTTGATAAAAGGAAGAAATTAGGAAAGGCTAATCAACTTGCTCAACACATCCAATACCAACAGACCTGGAATTTGAAACTAAGACAAAATATGTTATCACACTCTAGACTTGCCTTCGGCAGTGATGGTACTGATAAAAATAGACAAGACAAAAAAAAAAAAAGAATAAATGTTATCACACTGGTGCTAAAAAGGACTACTTGACA";
	$do2 ="GTGGGTTCATCAAACTCTAAGATGTTCCACTTATAAGTATAGGTTTCCCCTGGTTGAACTGCTCTGATCATGGTGTTGTTCCTGCCTGAAAGAAAATATATTCAAAATTGTTTTCATTTGCAAAGTTATTTCATGATAATAAATAAATAAATAAGCTTTCGCTGGAACCAATTAATATTGCAAAAGGAATTCTTTTATTTTTATTTTTTTTAAATTATACTTTAAGTTCTAGGGTACATGTGCACAACGTGCAGGTTTGTTACATATGTATACATGTGTCATGTTGGTGTGCTGCACCCATTAACTTGTCATTAACATTAGGTATATCTCCTAATGCTATCCCTCCCCCCGCCCCCCA";
	$up = ucwords(substr($seq,0,500));
	$up = $up2.substr($up,-100);
	$pos1 = strlen($up)+1;
	$do = ucwords(substr($seq,501));
	$do = substr($do,0,100).$do2;
	$url= "https://primer1.soton.ac.uk/cgi-bin/runprimer1.cgi?".$up.$a1.$do."+".$pos1."+".$a1."+".$a2."+27+30+24+200+300+100+1.5+1.1+65+".$Tmax."+".$Tmin."+".$gcmax."+".$gcmin."+8.00+3.00+50+50+1";
	
?>
<tr>
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
		
	if(GCcloseto50($fprimer,$rprimer)==$fprimer){
		$ori="FW"; $cpori="RW";
		$asp1 = substr($fprimer,0,strlen($fprimer)-1).$a1;
		$asp2 = substr($fprimer,0,strlen($fprimer)-1).$a2;
		if (tmmin($asp1,$asp2,$mgcon)==$asp1){
				$asp1 = tmred($asp1);
				$asp2 = tminc($asp2);
				$asplow = $asp1;
				$asphigh = $asp2;
				
			}else{
				$asplow = tmred($asp2);
				$asphigh = tminc($asp1);
			}
		
		$cplen = strlen($rprimer);
		$cplen2 = strlen($fprimer);
		$cp = rcom(substr($do,0,$cplen));
		$tar = array(substr($up,strlen($up)-($cplen2-1),strlen($up)),rcom($cp));
					
	}else{
		$ori="RW"; $cpori="FW";
		$a1 = Complement($a1);
		$a2 = Complement($a2);
		$asp1 = substr($rprimer,0,strlen($rprimer)-1).$a1;
		$asp2 = substr($rprimer,0,strlen($rprimer)-1).$a2;
		if (tmmin($asp1,$asp2,$mgcon)==$asp1){
				$asp1 = tmred($asp1);
				$asp2 = tminc($asp2);
				$asplow = $asp1;
				$asphigh = $asp2;
			}else{
				$asplow = tmred($asp2);
				$asphigh = tminc($asp1);
			}		
		$cplen = strlen($fprimer);
		$cplen2 = strlen($rprimer);
		$cp = strtoupper(substr($up,strlen($up)-($cplen),strlen($up)));
		$tar = array($cp,strtoupper(substr($do,0,$cplen-1)));
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
</td>
</tr>

    <tr>
      <td bgcolor="#D9D9D9" height="40px" valign="middle" colspan="3"><font size="+1"><strong>Output For dbSNP ID rs<?php echo $snp; ?> :</strong></font></td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="64" bgcolor="#D9D9D9">&nbsp;</td>
      <td width="59" bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td width="75" bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
      <td bgcolor="#D9D9D9">&nbsp;</td>
    </tr>
    
    <tr>
      <td bgcolor="#D9D9D9" colspan="2"><strong><abbr title="Allele 1 Specific Primer">Allele 1</abbr>:</strong>
	  <?php
	  echo " "."<abbr title='Allele-Direction'><span class='tmlow'><strong>$alow</strong></span>-$ori</abbr>";	  
	  ?>
      <strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($asplow)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($asplow)."% "; ?></td>
      <td bgcolor="#D9D9D9" align="left"><strong><abbr title="Melting Temperature">Tm</abbr>:</strong>
	  <?php echo tm_Base_Stacking($asplow,200,50,$mgcon)."<sup>o</sup>C "; ?>
      </td>
      <td bgcolor="#D9D9D9" colspan="2" width="500"><strong> | <abbr title="Allele 2 Specific Primer">Allele 2</abbr>:</strong>
	  <?php
	  echo " "."<abbr title='Allele-Direction'><span class='tmhig'><strong>$ahig</strong></span>-$ori</abbr>";	  
	  ?>
      <strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($asphigh)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($asphigh)."% "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="Melting Temperature">Tm</abbr>:</strong><?php echo tm_Base_Stacking($asphigh,200,50,$mgcon)."<sup>o</sup>C "; ?></td>
      <td bgcolor="#D9D9D9"><strong><font color="#D9D9D9">.</font>| <abbr title="Common Primer:Direction">Common:</strong><?php
	  echo $cpori;?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="Length">Len</abbr>:</strong><?php echo strlen($cp)."bp "; ?></td>
      <td bgcolor="#D9D9D9"><strong><abbr title="GC Content">GC</abbr>:</strong><?php echo GCcontent($cp)."% "; ?></td>
      <td bgcolor="#D9D9D9"><strong><strong><abbr title="Melting Temperature">Tm</abbr>:</strong><?php echo tm_Base_Stacking($cp,200,50,$mgcon)."<sup>o</sup>C"; ?></td>
    </tr>
    
    <tr height="40">
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
    </tr>
    
    <tr>
      <td bgcolor="#D9D9D9"><strong>Amplicon Size:</strong><?php echo strlen($asphigh.$cp); ?>bp</td>
      <td bgcolor="#D9D9D9" colspan="2" align="center"><strong>Chromosome :</strong><?php //replace 23 with X and 24 with Y chromosome
	if ($ch == 23){ echo "X";} else {	if ($ch == 24){ echo "Y";} else{echo $ch;}} ?>
	</td>
	<td bgcolor="#D9D9D9" colspan="2" align="center"><strong>Position:</strong><?php echo $pos; ?></td>
      <td bgcolor="#D9D9D9"><strong>Gene:</strong><?php echo $gene; ?></td>
      <td bgcolor="#D9D9D9" colspan="2" align="left"><strong>SNP Type:</strong>
      <?php	   echo $type;  ?> </td>
      <td bgcolor="#D9D9D9"><abbr title="Melting Temperature"><strong>Tm(<sup>o</sup>C)</strong></abbr></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmlow'><strong><abbr title='Homozygous Allele 1 (Low Tm)'>".$alow."/".$alow."</abbr></strong></span>"; ?></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmave'><strong><abbr title='Heterozygous'>".$alow."/".$ahig."</abbr></strong></span>"; ?></td>
      <td bgcolor="#D9D9D9" align="center"><?php echo "<span class='tmhig'><strong><abbr title='Homozygous Allele 2 (High Tm)'>".$ahig."/".$ahig."</abbr></strong></span>"; ?></td>
    </tr>
    <tr>
      <td height="50" colspan="8" align="center" bgcolor="#D9D9D9" valign="top">
      		<table width="650" border="1"><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php 
			if($ori=="RW"){
			echo rcom($tar[1])."[<span class='tmlow'><strong>".$alow."</strong></span>/"."<span class='tmhig'><strong>".$ahig."</strong></span>]".rcom($tar[0]);
			}else{
			echo $tar[0]."[<span class='tmlow'><strong>".$alow."</strong></span>"."/<span class='tmhig'><strong>".$ahig."</strong></span>]".$tar[1];	
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
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo round((tm_Base_Stacking(($asplow.$cp),200,50,$mgcon)+tm_Base_Stacking(($asphigh.$cp),200,50,$mgcon))/2,1); ?></td>
          </tr></table>
      </td>
      <td bgcolor="#D9D9D9" valign="top" align="center">
      		<table width="50" border="1" align="center" ><tr>
            <td bgcolor="#FFFFFF" align="center" height="25"><?php echo tm_Base_Stacking(($asphigh.$cp),200,50,$mgcon); ?></td>
          </tr></table>
      </td>
   
    </tr>
   
    <tr>
      <td colspan="4" bgcolor="#D9D9D9" align="right"><img src="untitled2.png" width="332" height="243"></td>
      <td colspan="4" bgcolor="#D9D9D9" align="center"><img src="untitled3.png" width="333" height="241"></td>
      <td colspan="4" bgcolor="#D9D9D9" align="left"><img src="untitled4.png" width="337" height="242"></td>
    </tr>
     <?php
}}
	
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