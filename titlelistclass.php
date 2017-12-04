<?php 
class titlelistclass {
	var $total = 0;
	var $itemcount = 0;
	var $items = array();
	var $mark=array();
	var $name=array();
	var $tel=array();
	var $email = array();
	var $des = array();
	
	
	function titlelistclass() {}
	
	function get_contents()
	{
		$items = array();
		foreach($this->items as $tmp_item)
		{
		        $item = FALSE;

			
            $item['id'] = $tmp_item;
			$item['name'] = $this->itemname[$tmp_item];
			$item['mark'] = $this->itemmark[$tmp_item];
			$item['tel'] = $this->itemtel[$tmp_item];
			$item['email'] = $this->itememail[$tmp_item];
			$item['des'] = $this->itemdes[$tmp_item];
            $items[] = $item;
		
		}
		return $items;
	}
	function add_item($itemid,$name = FALSE,$mark = FALSE,$tel = FALSE,$email = FALSE,$des = FALSE)
	{
		
			
		$this->items[]=$itemid;
		$this->itemname[$itemid] = $name;
		$this->itemmark[$itemid] = $mark;
		$this->itemtel[$itemid] = $tel;
		$this->itememail[$itemid] = $email;
		$this->itemdes[$itemid] = $des;
		
		
	}
	 function empty_item()
	{
            $this->total=0;
	        $this->itemcount = 0;
			$this->itemmark =array();
			$this->itemname =array();
			$this->itemtel =array();
	        $this->items = array();
            $this->itememail = array();
	        $this->itemdes = array();
          
	} 
	function del_item($itemid)
	{ 
		$ti = array();
		
		foreach($this->items as $item)
		{
			if($item != $itemid)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
		$this->_update_total();
	} 
	
	function edit_mark($itemid,$mark)
	{ 
	$this->itemst[$itemid] = $mark;
	} 
	
	function _update_total()
	{ 
	    $this->itemcount = 0;
		$this->total = 0;
               
                foreach($this->items as $item) {
                $this->total = count($this->name) ;
				$this->itemcount++;
			
		}
	} 

}