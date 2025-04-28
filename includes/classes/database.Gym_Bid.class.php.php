<?php
class Gym_Bid extends Database{	
	public $href=""; 
	public $dynamic_content=array(); 
	public $query_data=array(); 
	public $query_data_value=array(); 	

	public function check_whether_it_is_client_job($job_id,$client_id){
		if(trim($job_id) == NULL || trim($client_id) == NULL){
			return true; 	
		}else{			
			$sql="select id from jobs where client_id='" . $this->escape($client_id) . "' and id='" . $this->escape($job_id) . "'limit 1";			
			$result=$this->fetch_all_array($sql);
						
			if(count($result) == 1)
				return false; 	
			else
				return true;						
		}
	}	
	public function sub_category_exists($sub_cat_id){
		if(trim($sub_cat_id) == NULL){
			return false; 	
		}else{			
			$sql="select sub_cat_id from tbl_product where sub_cat_id='" . $this->escape($sub_cat_id) . "' limit 1";			
			$result=$this->fetch_all_array($sql);
						
			if(count($result) > 0){
				return true; 	
			}else{
				return false; 
			}			
		}
	}	
	
	public function product_exists($product_id){
		if(trim($product_id) == NULL){
			return false; 	
		}else{			
			$sql="select product_id from tbl_product where product_id='" . $this->escape($product_id) . "' limit 1";			
			$result=$this->fetch_all_array($sql);
						
			if(count($result) > 0){
				return true; 	
			}else{
				return false; 
			}			
		}
	}
			
	public function outfitter_name($id){
		$sql="select name from outfitters where id='" .$this->escape($id) . "'";
		$result=$this->fetch_all_array($sql);
		return ($result[0]['name']);
	}
	public function country_name($id){
		$country_name="";	
			
		if(trim($id) == NULL)
			return ($country_name);	
		else {
			$sql="select name from countries where id='" .$this->escape($id) . "'";
			$result=$this->fetch_all_array($sql);
			$country_name=$result[0]['name'];
			return ($country_name);
		}	
	}	
	
	public function taxidermy_name($id){
		$sql="select name from taxidermy where id='" . $this->escape($id) . "'";
		$result=$this->fetch_all_array($sql);
		return ($result[0]['name']);
	}
	
	public function package_available($outfitter_id){
		$sql="select id from outfitters_hunts where outfitter_id='" . $this->escape($outfitter_id). "' and african_hunt_packages=1 and hunt_available=1";
		$result=$this->fetch_all_array($sql);
		if(count($result) > 0)
			return (1); 
		else 
			return (0); 
	}
	
		
	
	
	public function static_page_content($page_name,$query_string){
		
		$sql="select * from static_pages where page_name='" . $this->escape($page_name) . "' limit 1";
		
		$result=$this->fetch_all_array($sql);
		
		if(count($result) > 0){			
		
			$this->dynamic_content['page_id']=$result[0]['id'];
			$this->dynamic_content['page_heading']=$result[0]['page_heading'];
			$this->dynamic_content['page_title']=$result[0]['title'];
			$this->dynamic_content['page_keywords']=$result[0]['keyword'];
			$this->dynamic_content['page_description']=$result[0]['description'];
			$this->dynamic_content['file_data']=$result[0]['file_data'];	
			
		}else if($page_name=="custom-page.php" || in_array($page_name, $do_not_show_array) ){	
			$sql_global="select * from static_pages  where seo_link='" . $this->escape($query_string) . "' limit 1";
			
			$result_global=$this->fetch_all_array($sql_global);
			
			if(count($result_global) == 1){				
				$this->dynamic_content['page_id']=$result_global[0]['id'];
				$this->dynamic_content['page_heading']=$result_global[0]['page_heading'];
				$this->dynamic_content['page_title']=$result_global[0]['title'];
				$this->dynamic_content['page_keywords']=$result_global[0]['keyword'];
				$this->dynamic_content['page_description']=$result_global[0]['description'];
				$this->dynamic_content['file_data']=$result_global[0]['file_data'];								
			}			
		}else{
			$sql_global="select option_name,option_value from tbl_options where  admin_admin_id =1 and (option_name='global_meta_title' or option_name='global_meta_keywords'  or option_name='global_meta_description')";
			 
			$result_global=$this->fetch_all_array($sql_global);
			
			
			if(count($result_global) > 0){
				for($i=0; $i <count($result_global); $i++){
					$$result_global[$i]['option_name']=trim($result_global[$i]['option_value']);
				}
			}
			
			$this->dynamic_content['page_title']=$global_meta_title;
			$this->dynamic_content['page_keywords']=$global_meta_keywords;
			$this->dynamic_content['page_description']=$global_meta_description;
			
		}	
		return ($this->dynamic_content);		
	}	
	
}
?>