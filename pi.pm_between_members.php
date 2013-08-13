<?php

/*
=====================================================
 PM between members
-----------------------------------------------------
 http://www.intoeetive.com/
-----------------------------------------------------
 Copyright (c) 2013 Yuri Salimovskiy
=====================================================
 This software is intended for usage with
 ExpressionEngine CMS, version 2.0 or higher
=====================================================
 File: pi.pm_between_members.php
-----------------------------------------------------
 Purpose: Stats on PM communication between 2 members
=====================================================
*/


$plugin_info = array(
		'pi_name'			=> 'PM between members',
		'pi_version'		=> '0.1',
		'pi_author'			=> 'Yuri Salimovskiy',
		'pi_author_url'		=> 'http://www.intoeetive.com/',
		'pi_description'	=> "Stats on PM communication between 2 members",
		'pi_usage'			=> Pm_between_members::usage()
	);


class Pm_between_members {

    var $return_data;
    
    /** ----------------------------------------
    /**  Constructor
    /** ----------------------------------------*/

    function __construct()
    {        
    	$this->EE =& get_instance(); 
    }
    /* END */	    

    
    /** ----------------------------------------
    /**  Count
    /** ----------------------------------------*/

    function count()
    {
        
        if ($this->EE->TMPL->fetch_param('sender')=='' || $this->EE->TMPL->fetch_param('recipient')=='') return;
		
		$this->EE->db->select('copy_id')
        	->from('message_copies')
        	->where('(sender_id = '.$this->EE->TMPL->fetch_param('sender').' OR recipient_id = '.$this->EE->TMPL->fetch_param('recipient').')')
        	->or_where('(recipient_id = '.$this->EE->TMPL->fetch_param('sender').' OR sender_id = '.$this->EE->TMPL->fetch_param('recipient').')');

       	$q = $this->EE->db->get();
       	
       	$this->return_data =  $q->num_rows();
       	
       	return $this->return_data;

    }
    /* END */
    
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
Get number of messages between members:
{exp:pm_between_members:count sender="{segment_3}" recipient="{segment_4}"}

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
/* END */


}
// END CLASS
?>