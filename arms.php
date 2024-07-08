<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style> 
p.test {
    width: 600px; 
    word-wrap: break-word;
}
input[type="number"] {
    width: 42px;
}
input[type="text"] {
    width: 30px;
}
</style>
<script src="SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="icon" href="img2.png" type="image/x-icon">
<title>ARMS-PCR Design Tool</title>
<style type="text/css">
<!--
.style1 {color: #123}
-->
</style>
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->
<link href="css/bootstrap-3.3.6.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<ul class="nav nav-tabs">
  <li role="disabled"><a href="index.php"><div align="center" style="font-size: 14px; alignment-baseline:middle">SNPgen<sup>®</sup> Home</div></a></li>
  <li role="presentation" ><a href="SNPinfo.php">SNP info</a></li>
  <li role="presentation" class="active"><a href="arms.php">ARMS-PCR design</a></li>
  <li role="presentation" ><a href="hrm.php">HRM Assay Design (dbSNP)</a></li>
  <li role="presentation"><a href="hrm-m.php">HRM Assay Design</a></li>
  <li role="presentation"><a href="hrm-indel.php">HRM Assay Design(Indel)</a></li>
</ul>
<br>
<table width="916" border="0" align="center" class="bg-success">
<tr>
<td width="263" rowspan="8" valign="top" bgcolor="#FFFFFF" class="bg-success"><img src="arms.png" width="262" height="514" alt=""/>
<br><br>
<strong>References: </strong><br>
Andrew Collins, Xiayi Ke <br>
Primer1: primer design web service for tetra-primer ARMS-PCR. <br>
The Open Bioinformatics Journal, 2012, 6: 55-58 <br>
<br>
Shu Ye, Sahar Dhillon, Xiayi Ke, Andrew R.Collins and Ian N.M.Day<br>
An efficient procedure for genotyping single nucleotide polymorphisms.<br>
Nucleic Acid Research, 2001, Vol. 29, No. 17, E88-8
</td>
<td height="45" colspan="5" valign="top" align="center"><strong class="h2">Tetra ARMS - PCR Primer Design Tool</strong></td>
</tr>
<tr height="50px">
<form id="form1" name="form1" method="get" action="">
	
    <td width="178" valign="top"><strong>Enter dbSNP ID (rs#): </strong></td>
    <td  colspan="2" valign="top" align="center"><span id="sprytextfield1">
    <label>rs
     <?php
		if($_GET==null){
			?>
			<input name="snpid" type="text1" class="style1" id="snpid" onfocus="this.value=''" value="6025"/>
            <?php
		}else{?>
			<input name="snpid" type="text1" class="style1" id="snpid" onfocus="this.value=''" value="<?php echo $_GET['snpid']; ?>"/>
		<?php	}
	  ?>
    </label>
    <br>
    <span class="textfieldRequiredMsg">A Number is required.</span><span class="textfieldMinCharsMsg">Minimum No. of digits not met.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span></span></td>
     <td width="143" valign="top">
      <label>
      <strong><input type="submit" value="GET ALLELES" name="search" id="search" >  
</strong>
      </label>
</td></form>
<td width="25" valign="top">
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
</td>
</tr>
<form method="post">
<tr height="30px">
  <td valign="top" bgcolor="#FAFAA9"><strong>Allele 1 :
    <select name="a1" id="a1">
   <?php 
		echo "<option value=$allele1>".$allele1."</option>";
		echo "<option value=$allele2>".$allele2."</option>";
	?>
    </select>
  </strong></td>
  <td width="136" valign="top" bgcolor="#FAFAA9" align="right"><strong>Allele 2 :
    <select name="a2" id="a2"> <?php 
			echo "<option value=$allele2>".$allele2."</option>";
			echo "<option value=$allele1>".$allele1."</option>";
		?>
    </select>
  </strong></td>
  <td width="145" align="right" valign="top" bgcolor="#FAFAA9"><strong>(G+C)% :  </strong></td>
  <td valign="top" align="center" bgcolor="#FAFAA9">
  <?php
		if($_POST==null){
			?>
			<input name="gcmin" type="number" id="gcmin" value="20" size="0" maxlength="2" min="20" step="1" max="60">
            <input name="gcmax" type="number" id="gcmax" value="80" size="2" maxlength="2" min="40" max="80" step="1">
            <?php
		}else{?>
			<input name="gcmin" type="number" id="gcmin" size="0" maxlength="2" min="20" step="1" max="60" value="<?php echo $_POST['gcmin']; ?>"/>
            <input name="gcmax" type="number" id="gcmax" size="2" maxlength="2" min="40" max="80" step="1" value="<?php echo $_POST['gcmax']; ?>" />
		<?php	}	  ?>
     <br>
    Min -  Max</td>
  <td valign="middle"></td>
 </tr>
<tr height="30px">
  <td height="62" align="left" valign="middle" bgcolor="#FAFAA9"><strong>Primer Size (bp) : </strong></td>
  <td valign="middle" bgcolor="#FAFAA9" align="center"><?php if($_POST==null){ ?>
    <input name="pmin" type="number" id="pmin" value="26" size="1" maxlength="2" min="15" step="1" max="28">
    <input name="popt" type="number" id="popt" value="28" size="1" maxlength="2" min="20" step="1" max="32">
    <input name="pmax" type="number" id="pmax" value="30" size="1" maxlength="2" min="28" step="1" max="35">
	<?php }else{?>
        <input name="pmin" type="number" id="pmin" size="1" maxlength="2" min="15" step="1" max="28" value="<?php echo $_POST['pmin']; ?>">
    <input name="popt" type="number" id="popt" size="1" maxlength="2" min="20" step="1" max="32" value="<?php echo $_POST['popt']; ?>">
    <input name="pmax" type="number" id="pmax" size="1" maxlength="2" min="28" step="1" max="35" value="<?php echo $_POST['pmax']; ?>">
    <?php	}	  ?>
    <br>Min - Opt - Max </td>
  <td align="right" valign="middle" bgcolor="#FAFAA9"><strong>Tm (Celcius) :</strong></td>
  <td valign="middle" bgcolor="#FAFAA9" align="center"><br><?php if($_POST==null){ ?>
	<input name="tmin" type="number" id="tmin" value="50" size="1" maxlength="2" min="50" step="1" max="65">
    <input name="topt" type="number" id="topt" value="65" size="1" maxlength="2" min="55" step="1" max="65">
    <input name="tmax" type="number" id="tmax" value="80" size="1" maxlength="2" min="60" step="1" max="80">
    <?php }else{?>
    <input name="tmin" type="number" id="tmin" size="1" maxlength="2" min="50" step="1" max="65" value="<?php echo $_POST['tmin']; ?>">
    <input name="topt" type="number" id="topt" size="1" maxlength="2" min="55" step="1" max="65" value="<?php echo $_POST['topt']; ?>">
    <input name="tmax" type="number" id="tmax" size="1" maxlength="2" min="60" step="1" max="80" value="<?php echo $_POST['tmax']; ?>">
    <?php }	?>
    <br>
    Min - Opt - Max</td>
  <td valign="middle"></td>
</tr>
<tr height="30px">
  <td height="37" align="left" valign="middle" bgcolor="#FAFAA9"><strong>Salt Conc. (mM) :  </strong></td>
  <td valign="middle" bgcolor="#FAFAA9" align="center"><?php if($_POST==null){ ?>
  <input name="salt" type="text" id="salt" value="50" size="2" maxlength="2"><?php }else{?>  
  <input name="salt" type="text" id="salt" size="2" maxlength="2" value="<?php echo $_POST['salt']; ?>">  
  <?php }	?><br>
	</td>
  <td align="right" valign="middle" bgcolor="#FAFAA9"><strong>Primer Conc. (nM) :</strong></td>
  <td colspan="1" align="center" valign="middle" bgcolor="#FAFAA9"><?php if($_POST==null){ ?>
  <input name="pconc" type="text" id="pconc" value="50" size="2" maxlength="2"><?php }else{?>
  <input name="pconc" type="text" id="pconc" size="2" maxlength="2" value="<?php echo $_POST['pconc']; ?>">
  <?php }	?></td>
  <td valign="middle" colspan="1"></td>
</tr>
<tr height="30px">
  <?php
  	   	if ($type!="SNV"){
				echo "<td height='31' valign='middle' colspan='4' align='center' bgcolor='#F86467' >";
				echo "<h3 align='center'>Error: This Tool  Works For Single Base Variations Only</h3><br>";
				echo "<h4 align='center'>Not With Insertions / Deletions / Any Other Type of Variations </h4></td>";
				exit;
		}else{}
  ?>
  <td height="31" valign="middle" bgcolor="#FAFAA9" >&nbsp;</td>
  <td colspan="2" align="center" valign="middle" bgcolor="#FAFAA9"><strong>
   <input type="submit" name="submit" id="submit" value="DESIGN"></strong>
  </td>
  <td colspan="1" valign="middle" bgcolor="#FAFAA9"></td>
  <td valign="top" colspan="1"></td>
</tr></form>
<?php if(isset($_POST["submit"])){
	$a1 = $_POST['a1'];	$a2 = $_POST['a2'];
	$gcmin = $_POST["gcmin"];	$gcmax = $_POST["gcmax"];	
	$pmin = $_POST["pmin"];		$popt = $_POST["popt"];		$pmax = $_POST["pmax"];
	$Tmin = $_POST["tmin"]; 	$Topt = $_POST["topt"];		$Tmax = $_POST["tmax"];
	$salt = $_POST["salt"];	$pconc = $_POST["pconc"];
	$up = ucwords(substr($seq,0,500));
	$pos1 = 501;
	$do = ucwords(substr($seq,501));
	$url= "https://primer1.soton.ac.uk/cgi-bin/runprimer1.cgi?".$up.$a1.$do."+".$pos1."+".$a1."+".$a2."+".$popt."+".$pmax."+".$pmin."+200+300+100+1.5+1.1+".$Topt."+".$Tmax."+".$Tmin."+".$gcmax."+".$gcmin."+8.00+3.00+".$salt."+".$pconc."+2";
?>
<tr height="30px">
  <td valign="middle" bgcolor="#FAFAA9"><strong>Output for dbSNP ID <?php echo "rs".$snp; ?> :</strong></td>
  <td align="right" valign="middle" bgcolor="#FAFAA9"></td>
  <td align="center" valign="middle" bgcolor="#FAFAA9"><strong><?php 
  $msi="SNPinfo.php?search=Search&snpid=".$snp;
  echo "<a href='$msi'>SNP_info</a>" ?></strong></td>
  <td align="center" valign="middle" bgcolor="#FAFAA9"><strong><?php 
  $ncbi="https://www.ncbi.nlm.nih.gov/SNP/snp_ref.cgi?type=rs&rs=".$snp;
  echo "<a href='$ncbi'>dbSNP_Webpage</a>" ?></strong></td>
  <td valign="middle"></td>
</tr>
<tr>
  <td valign="middle" colspan="4">
    <?php 
	$home= file_get_contents($url);
	$ele=explode("<pre>",$home);
	echo "<pre>";
	echo $home;
	echo "</pre>"; 
}
	}else { 
	}
?>
</td>
  <td valign="middle"></td>
</tr>
    <tr bgcolor="#FFFFFF"></form>
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

