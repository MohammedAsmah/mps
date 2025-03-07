<?php

function int2str($a){
	if ($a<0) return 'moins '.int2str(-$a);
	if ($a<17){
		switch ($a){
			case 0: return '';
			case 1: return 'Un';
			case 2: return 'Deux';
			case 3: return 'Trois';
			case 4: return 'Quatre';
			case 5: return 'Cinq';
			case 6: return 'Six';
			case 7: return 'Sept';
			case 8: return 'Huit';
			case 9: return 'Neuf';
			case 10: return 'Dix';
			case 11: return 'Onze';
			case 12: return 'Douze';
			case 13: return 'Treize';
			case 14: return 'Quatorze';
			case 15: return 'Quinze';
			case 16: return 'Seize';
		}
	} else if ($a<20){
		return 'Dix-'.int2str($a-10);
	} else if ($a<100){
		if ($a%10==0){
			switch ($a){
				case 20: return 'Vingt';
				case 30: return 'Trente';
				case 40: return 'Quarante';
				case 50: return 'Cinquante';
				case 60: return 'Soixante';
				case 70: return 'Soixante-dix';
				case 80: return 'Quatre-Vingt';
				case 90: return 'Quatre-Vingt-Dix';
			}
		} else if ($a<70){
			return int2str($a-$a%10).' '.int2str($a%10);
		} else if ($a<80){
			return int2str(60).' '.int2str($a%20);
		} else{
			return int2str(80).' '.int2str($a%20);
		}
	} else if ($a==100){
		return 'Cent';
	} else if ($a<200){
		return int2str(100).' '.int2str($a%100);
	} else if ($a<1000){
		return int2str((int)($a/100)).' '.int2str(100).' '.int2str($a%100);
	} else if ($a==1000){
		return 'Mille';
	} else if ($a<2000){
		return int2str(1000).' '.int2str($a%1000).' ';
	} else if ($a<1000000){
		return int2str((int)($a/1000)).' '.int2str(1000).' '.int2str($a%1000);
	}  
	//on pourrait pousser pour aller plus loin, mais c'est sans interret pour ce projet, et pas interessant, c'est pas non plus compliqué...
}

?>
