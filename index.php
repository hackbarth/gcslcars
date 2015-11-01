<pre>
<?php
$xml=simplexml_load_file("gcs/".$_REQUEST['char'].".gcs");

function readadv($trtvalue) {
	global $bonus; 
			foreach($trtvalue as $advantage=>$advvalue) // each advantage is dealt here
			if($advantage=="advantage_container"){
			if ($traits) $traits.= ', ';
				$traits.= $advvalue->name.'('.readadv($advvalue).')'; 
				}
			else	if($advantage=="advantage")
			{
			{			
			if ($traits) $traits.= ', ';
			  $traits.= $linha=$advvalue->name; 
			if ($advvalue->notes) $traits.= ' ('.$advvalue->notes.') ';
			if ($advvalue->levels) $traits.= ' '.$advvalue->levels;
			if( $advvalue->skill_bonus) foreach($advvalue->skill_bonus as $child) { //fills an array of bonuses to skills given by advantages
				$linha=$child->name.'';
				$bonus[strtolower(trim($linha))]+=$advvalue->levels; 
				}
			if( $advvalue->attribute_bonus) foreach($advvalue->attribute_bonus as $child) { //fills an array of bonuses to attributes given by advantages
				$linha=$child->attribute.'';
				if ($advvalue->levels)
					$bonus[strtolower(trim($linha))]+=($advvalue->levels)*($child->amount); 
				else
					$bonus[strtolower(trim($linha))]+=$child->amount;
			}
		}
}
return $traits;
}



foreach($xml as $trait=>$trtvalue) // runs trough the gcs file tags
	if($trait=="advantage_list")
		$traits .=	readadv($trtvalue);

	else 
	if($trait=="skill_list")
		foreach($trtvalue as $skill=>$skillvalue)
			{			
			$snome=$skillvalue->name;
			$sdefault=$skillvalue->default->name;
			$sdefaultmod=$skillvalue->default->modifier;
			$snote=$skillvalue->specialization;
			$stipo=explode("/",$skillvalue->difficulty);
			$spontos=$skillvalue->points;
			$sbonus=$bonus[strtolower(trim($snome))];
			switch ($stipo[0]){
				case 'IQ': $sbase=$xml->IQ+$bonus['iq']; break;
				case 'DX': $sbase=$xml->DX+$bonus['dx']; break;
				case 'Will': $sbase=$xml->will+10+$bonus['will']; break;
				case 'Per': $sbase=$xml->perception+10+$bonus['perception']; break;
				case 'HT': $sbase=$xml->HT+$bonus['ht']; break;
				}			
			switch ($stipo[1]){
				case 'E': $sdiff=3; break;
				case 'A': $sdiff=2; break;
				case 'H': $sdiff=1; break;
				case 'VH': $sdiff=0; break;
				}
	if ($spontos<4)
		$final = $sbase-4+$spontos+$sdiff+$sbonus;
	else
		$final = $sbase-2+floor($spontos/4)+$sdiff+$sbonus;
	if($skill == technique) 
		$final = ($skills[$sdefault.'']+$sdefaultmod+$spontos);
		if ($stipo[0]=='H')
			$final--;
	if($skill == skill_container)
		$final =$skillvalue->notes;

//	echo $skill.' '.$snome.' '.$stipo[0].'/'.$stipo[1].' ['.$sbase .'] points:'.($spontos).' bonus:'. $sbonus.' total:'. $final.$sdefault.$sdefaultmod.($skills[$sdefault.'']+$sdefaultmod+$spontos).' <br>'; 

	if ($snote) $snome.=' ('.$snote.')';
	
	 $skills[$snome.'']=$final;
	}

//print_r($bonus);print_r($skills);

// Filling in the Biopic with text from the NOTES part of the file.
$notes=explode("\n",$xml->profile->notes);
foreach ($notes as $line) $biopic[explode(":",$line)[0]]=explode(":",$line)[1];

?>
</pre>

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<title>LCARS Personnel Database</title>
	<link rel="stylesheet" type="text/css" href="css/lcars.css">
</head>
<body>
	
<ul id="side-panel" class="side-panel">
<li class="bio">
	Biopic
</li>
</ul>

<h1>USS NAUTILUS PERSONNEL DATABASE</h1>

<table id="biopic">
		<tbody><tr>
			<td>NAME: <?php echo $biopic["NAME"]; ?></td>
			<td>STAR FLEET RANK: <?php echo $biopic["STAR FLEET RANK"]; ?></td>
			<td>PLACE OF BIRTH: <?php echo $biopic["PLACE OF BIRTH"]; ?></td>
		</tr><tr>
			<td>HOME PLANET: <?php echo $biopic["HOME PLANET"]; ?></td>
			<td>ASSIGNMENT: <?php echo $biopic["ASSIGNMENT"]; ?></td>
			<td>DATE OF BIRTH: <?php echo $biopic["DATE OF BIRTH"]; ?></td>
			</tr><tr>
			<td></td>
			<td>USS NAUTILUS NCC 76171</td>
			<td>PARENTS: <?php echo $biopic["PARENTS"]; ?></td>
		</tr>	
	</tbody>
</table>
	
	<div class="line-middle">
	<div class="top"></div>
	<div class="bottom"> </div>
	</div>
	
<ul id="side-panel" class="side-panel">
	<li class="att">
		Attributes
	</li>
	<li class="sideadvdisadv">
	Traits
	</li>
	<li class="sideskills">
		Skills
	</li>
</ul>	

<div style=" float:left; width:90%">
<table id="basicattr">
		<tbody><tr>
			<td class="attr st">
				ST
			</td>
			<td class="attrvalue stvalue">
				<?php echo $st = $xml->ST+$bonus['st']; $pv = $xml->ST+$bonus['st']+$bonus['hp']; ?>
			</td>
		</tr>
		<tr>
			<td class="attr dx">
				DX
			</td>
			<td class="attrvalue dxvalue">
				<?php echo $dx = $xml->DX+$bonus['dx']; ?>
			</td>
		</tr>		<tr>
			<td class="attr iq">
				IQ
			</td>
			<td class="attrvalue iqvalue">
				<?php echo $iq = $xml->IQ+$bonus['iq']; ?>
			</td>
		</tr>		<tr>
			<td class="attr ht">
				HT
			</td>
			<td class="attrvalue htvalue">
				<?php echo $ht = $xml->HT+$bonus['ht']; ?>
			</td>
		</tr>	
	</tbody></table>
<table id="secondattr">
		<tbody><tr>
			<td class="attr fat">
				Fat
			</td>
			<td class="attrvalue fatvalue">
				<?php echo $fd = $xml->HT+$bonus['ht']; ?>
			</td>
		</tr>	
		<tr>
			<td class="attr will">
				Will
			</td>
			<td class="attrvalue willvalue">
				<?php echo $xml->will+10+$bonus['will']; ?>
			</td>
		</tr>		<tr>
			<td class="attr per">
				Per
			</td>
			<td class="attrvalue pervalue">
				<?php echo $xml->perception+10+$bonus['perception']; ?>
			</td>
		</tr>
		<tr>
			<td class="attr dodge">
				Dodge
			</td>
			<td class="attrvalue dodgevalue">
				<?php echo $dg = floor((($dx+$ht)/4)+(float)$xml->speed)+3+$bonus['dodge'];?>
			</td>
		</tr>	
	</tbody></table>
	
<table id="hitpoints">
	<tr><td></td><td rowspan=10 id="dial1" ></td><td>Hit Points</td><td rowspan=10 id="dial2"></td><td></td></tr>
	<tr><td><?php echo $pv; ?></td><td>Unharmed</td><td><?php echo $pv; ?></td></tr>
	<tr><td><?php echo floor($pv/3); ?></td><td>Reeling</td><td><?php echo floor($pv/3); ?></td></tr>
	<tr><td>0</td><td>Collapse</td><td>0</td></tr>
	<tr><td><?php echo $pv*(-1) ?></td><td>Check#1</td><td><?php echo $pv*(-1) ?></td></tr>
	<tr><td><?php echo $pv*(-2) ?></td><td>Check#2</td><td><?php echo $pv*(-2) ?></td></tr>
	<tr><td><?php echo $pv*(-3) ?></td><td>Check#3</td><td><?php echo $pv*(-3) ?></td></tr>
	<tr><td><?php echo $pv*(-4) ?></td><td>Check#4</td><td><?php echo $pv*(-4) ?></td></tr>
	<tr><td><?php echo $pv*(-5) ?></td><td>Dead</td><td><?php echo $pv*(-5) ?></td></tr>
	<tr style="height:47px;"></tr>
</table>
			<img src=<?php echo '"img/'.$_REQUEST['char'].'.jpg"' ?> id="photo" alt="Personnel Photo" height="350" width="300">
		
		<p id="advdisadv"><?php echo $traits; ?></p>
<table id="skillslist1">
	<tbody>
<?php
$i=0;
foreach ($skills as $nome=>$valor){

if ($i >= sizeof($skills)/3 and $i < (sizeof($skills)/3)+1) 
echo'</tbody></table>
<table id="skillslist2">
	<tbody>';
	if ($i >= sizeof($skills)*2/3 and $i < (sizeof($skills)*2/3)+1) 
echo'</tbody></table>
<table id="skillslist1">
	<tbody>';

echo'		<tr>
			<td class="skill">
				'.$nome.'
			</td>
			<td class="skilllevel">
				'.$valor.'
			</td><td class="skillcap">&nbsp;</td>
		</tr>
';
$i++;
}
?>
	</tbody>
</table>
</div>
</body>
</html>
