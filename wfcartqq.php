<?php

class wfCart {
	var $total = 0;
	var $itemcount = 0;
	var $itemst=array();
	var $itemot=array();
	var $itemdate=array();
	var $items = array();
	var $itemprices = array();
	var $itemqtys = array();
	var $iteminfo = array();
	var $st = "09:00:00";
	var $ot = "12:00:00";
	var $date = "2015-10-10";

	function cart() {} // constructor function

	function get_contents()
	{ // gets cart contents
		$items = array();
		foreach($this->items as $tmp_item)
		{
		        $item = FALSE;

			$item['id'] = $tmp_item;
            $item['qty'] = $this->itemqtys[$tmp_item];
			$item['price'] = $this->itemprices[$tmp_item];
			$item['info'] = $this->iteminfo[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];
			$item['st'] = $this->itemst[$tmp_item];
			$item['ot'] = $this->itemot[$tmp_item];
			$item['date'] = $this->itemdate[$tmp_item];
            $items[] = $item;
			
		}
		return $items;
	} // end of get_contents


	function add_item($itemid,$qty=1,$price = FALSE, $info = FALSE, $st = "09:00:00", $ot = "12:00:00", $date = "2015-10-10")
	{ // adds an item to cart
                
		if($this->itemqtys[$itemid] > 0)
                { // the item is already in the cart..
		  // so we'll just increase the quantity
			$this->itemqtys[$itemid] = $qty + $this->itemqtys[$itemid];
			$this->_update_total();
		} else {
			$this->items[]=$itemid;
			$this->itemqtys[$itemid] = $qty;
			$this->itemprices[$itemid] = $price;
			$this->iteminfo[$itemid] = $info;
			$this->itemst[$itemid] = $st;
			$this->itemot[$itemid] = $ot;
			$this->itemdate[$itemid] = $date;
		}
		$this->_update_total();
	} // end of add_item


	function edit_item($itemid,$qty)
	{ // changes an items quantity
	  
		if($qty < 1) {
			$this->del_item($itemid);
		} else {
			$this->itemqtys[$itemid] = $qty;
			// uncomment this line if using 
			// the wf_get_price function
			// $this->itemprices[$itemid] = wf_get_price($itemid,$qty);
		}
		$this->_update_total();
	} // end of edit_item
	
	
	function edit_st($itemid,$st)
	{ // changes an items quantity
	$this->itemst[$itemid] = $st;
	} // end of edit_st

	function edit_ot($itemid,$ot)
	{ // changes an items quantity
	$this->itemot[$itemid] = $ot;
	} // end of edit_ot
	
	function edit_date($itemid,$date)
	{ // changes an items quantity
	$this->itemdate[$itemid] = $date;
	} // end of edit_date
	
	function del_item($itemid)
	{ // removes an item from cart
		$ti = array();
		$this->itemqtys[$itemid] = 0;
		foreach($this->items as $item)
		{
			if($item != $itemid)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
		$this->_update_total();
	} //end of del_item


        function empty_cart()
	{ // empties / resets the cart
            $this->total = 0;
	        $this->itemcount = 0;
			$this->itemst =array();
			$this->itemot =array();
			$this->itemdate =array();
	        $this->items = array();
            $this->itemprices = array();
	        $this->itemqtys = array();
            $this->iteminfo = array();
	} // end of empty cart


	function _update_total()
	{ // internal function to update the total in the cart
	        $this->itemcount = 0;
		$this->total = 0;
                if(sizeof($this->items > 0))
		{
                        foreach($this->items as $item) {
                                $this->total = $this->total + ($this->itemprices[$item] * $this->itemqtys[$item]);
				$this->itemcount++;
			}
		}
	} // end of update_total
}
?>

