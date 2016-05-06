<?php
/*********************************************************************
    class.nav.php

    Navigation helper classes. Pointless BUT helps keep navigation clean and free from errors.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2010 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
    $Id: $
**********************************************************************/
class StaffNav {
    var $tabs=array();
    var $submenu=array();

    var $activetab;
    var $ptype;

    function StaffNav($pagetype='staff'){
        global $thisuser;

        $this->ptype=$pagetype;
        $tabs=array();
        if($thisuser->isAdmin() && strcasecmp($pagetype,'admin')==0) {
            $tabs['dashboard']=array('desc'=>'Πίνακας Ελέγχου','href'=>'admin.php?t=dashboard','title'=>'Πίνακας Ελέγχου Διαχειριστή');
            $tabs['settings']=array('desc'=>'Ρυθμίσεις','href'=>'admin.php?t=settings','title'=>'Ρυθμίσεις Συστήματος');
            $tabs['emails']=array('desc'=>'Emails','href'=>'admin.php?t=email','title'=>'Ρυθμίσεις Email');
            $tabs['topics']=array('desc'=>'Είδη Επικοινωνίας','href'=>'admin.php?t=topics','title'=>'Είδη Επικοινωνίας');
            $tabs['staff']=array('desc'=>'Χρήστες','href'=>'admin.php?t=staff','title'=>'Χρήστες');
            $tabs['depts']=array('desc'=>'Φορείς','href'=>'admin.php?t=depts','title'=>'Φορείς');
        }else {
            $tabs['tickets']=array('desc'=>'Μηνύματα','href'=>'tickets.php','title'=>'Ιστορικό Μηνυμάτων');
            if($thisuser && $thisuser->canManageKb()){
             $tabs['kbase']=array('desc'=>'Πρότυπα','href'=>'kb.php','title'=>'Βάση Προτύπων: Προετοιμασμένα');
            }
            $tabs['directory']=array('desc'=>'Χρήστες','href'=>'directory.php','title'=>'Χρήστες');
          //kar//  $tabs['profile']=array('desc'=>'Ο Λογαριασμός μου','href'=>'profile.php','title'=>'Ο Λογαρισμός μου');
        }
        $this->tabs=$tabs;    
    }
    
    
    function setTabActive($tab){
            
        if($this->tabs[$tab]){
            $this->tabs[$tab]['active']=true;
            if($this->activetab && $this->activetab!=$tab && $this->tabs[$this->activetab])
                 $this->tabs[$this->activetab]['active']=false;
            $this->activetab=$tab;
            return true;
        }
        return false;
    }
    
    function addSubMenu($item,$tab=null) {
        
        $tab=$tab?$tab:$this->activetab;
        $this->submenu[$tab][]=$item; 
    }

    
    
    function getActiveTab(){
        return $this->activetab;
    }        

    function getTabs(){
        return $this->tabs;
    }

    function getSubMenu($tab=null){
      
        $tab=$tab?$tab:$this->activetab;  
        return $this->submenu[$tab];
    }
    
}
?>
