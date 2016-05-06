<?php
/*********************************************************************
    class.idiotita.php  - custom code extending osticket

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
    $Id: $
**********************************************************************/

/*
 * Mainly used as a helper...
 * Readonly object
 */

class Idiotita {
    var $id;
    var $name;
       
    function Idiotita($id,$fetch=true){
        $this->id=$id;
        if($fetch)
            $this->load();
    }

    function load() {

        if(!$this->id)
            return false;
        
        $sql='SELECT * FROM '.IDIOTITES_TABLE.' WHERE idiotita_id='.db_input($this->id);
        if(($res=db_query($sql)) && db_num_rows($res)) {
            $info=db_fetch_array($res);
            $this->id=$info['idiotita_id'];
            $this->name=$info['name'];
            
            return true;
        }
        $this->id=0;
        
        return false;
    }
  
    function reload() {
        return $this->load();
    }
    
    function getId(){
        return $this->id;
    }
    
    function getName(){
        return $this->name;
    }
    
    

    function update($vars,&$errors) {
        if($this->save($this->getId(),$vars,$errors)){
            $this->reload();
            return true;
        }
        return false;
    }

   } //end class
?>
