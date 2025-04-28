<?php

function pagination($per_page = 10, $page = 1, $url = '', $total){
	$adjacents = "2";
	
	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;

	$pagination = "";

	if($lastpage > 1){
		$pagination .= "";
		$pagination .= "";
		
		if ($lastpage < 7 + ($adjacents * 2)){
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page)
					$pagination.= "<b>$counter</b>";
				else
					$pagination.= "<a href='{$url}$counter'>$counter</a>";
			}
		}elseif($lastpage > 5 + ($adjacents * 2)){
			if($page < 1 + ($adjacents * 2)){
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $page)
						$pagination.= "<b>$counter</b>";
					else
						$pagination.= "<a href='{$url}$counter'>$counter</a>";
				}
				$pagination.= "<span>...</span>";
				$pagination.= "<a href='{$url}$lpm1'>$lpm1</a>";
				$pagination.= "<a href='{$url}$lastpage'>$lastpage</a>";
			}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
				$pagination.= "<a href='{$url}1'>1</a>";
				$pagination.= "<a href='{$url}2'>2</a>";
				$pagination.= "<span>...</span>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if ($counter == $page)
						$pagination.= "<b>$counter</b>";
					else
						$pagination.= "<a href='{$url}$counter'>$counter</a>";
				}
				$pagination.= "<span>...</span>";
				$pagination.= "<a href='{$url}$lpm1'>$lpm1</a>";
				$pagination.= "<a href='{$url}$lastpage'>$lastpage</a>";
			}else{
				$pagination.= "<a href='{$url}1'>1</a>";
				$pagination.= "<a href='{$url}2'>2</a>";
				$pagination.= "<span>...</span>";
				
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if ($counter == $page)
						$pagination.= "<b>$counter</b>";
					else
						$pagination.= "<a href='{$url}$counter'>$counter</a>";
				}
			}
		}

		if ($page < $counter - 1){
			$pagination.= "<a href='{$url}$next'>Next > ></a>";
			// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
		}else{
			//$pagination.= "<li><a class='current'>Next</a></li>";
			// $pagination.= "<li><a class='current'>Last</a></li>";
		}
	$pagination.= "\n";
	}
return $pagination;
}

?>