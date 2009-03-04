<?php

/**
 * Karambit Killboard System
 *
 * Builds and checks the path constants.
 *
 * PHP version 5
 *
 * LICENSE: This file is part of EVE MultiPurpose Application also know as KarambitKS.
 * KarambitKS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * KarambitKS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with KarambitKS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2009 (C) Michael Cummings, Stephen Gulick, and Andy Snowden 
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    KarambitKS
 * @version    SVN: $Id$
 * @link       http://code.google.com/p/karambitks/
 * @link       http://www.eve-online.com/
 */


/**
 * killList
 * 
 * @package KarambitKS
 * @author Stephen Gulick
 * @copyright 2009
 * @version $Id: class.killlist.php 31 2009-03-04 09:28:54Z stephenmg12 $
 * @access public
 */
class killList 
{   
    /**
     * 
     * @var object
     */
    private $rs_detail;
    
    /**
     * 
     * @var array
     */
    public $rarray_detail;
    
    /**
     * 
     * @var object
     */
    private $rs_attackers;
    
    /**
     * 
     * @var array
     */
    public $rarray_attackers;

    /**
     * killList::fetchAttackers()
     * 
     * Use this to fetch detail on a kill
     * 
     * @param mixed $ID
     * @return void
     */
    function fetchAttackers(int $killID) {
            //Get ADODB Factory INSTANCE
            $instance = ADOdbFactory::getInstance();
            //Get DB Connection
            $con = $instance->factory(KKS_DSN);
            
            
            $sql = 'SELECT `allianceID`, `allianceName`, `characterID`, `characterName`, `corporationID`, `corporationName`, `factionID`, `factionName`, `damageDone`, `finalBlow`, st.typeName AS shipType, wt.typeName AS weaponType FROM `corpAttackers` ca'
        . ' JOIN invTypes st ON st.typeID=ca.`shipTypeID`'
        . ' JOIN invTypes wt ON wt.typeID=ca.`weaponTypeID`'
        . ' WHERE kl.`killID`='.$killID.' LIMIT 0, 50 '; 
        

            if($this->rs=$con->CacheExecute(KKS_CACHE_KILLLIST, $sql)){
            	$this->rarray_attackers=$this->rs_attackers->GetAssoc();
            } else {
            	trigger_error('SQL Query Failed', E_USER_ERROR);
            }
            
    }
    
    /**
     * killList::fetchDetail()
     * 
     * Use this to fetch detail on a kill
     * 
     * @param mixed $ID
     * @return void
     */
    function fetchDetail(int $killID) {
            //Get ADODB Factory INSTANCE
            $instance = ADOdbFactory::getInstance();
            //Get DB Connection
            $con = $instance->factory(KKS_DSN);
            
            
            $sql = 'SELECT * FROM `corpKillLog` kl'
        . ' JOIN corpVictim cv ON cv.`killID`=kl.`killID`'
        . ' WHERE kl.`killID`='.$killID.' LIMIT 1 '; 
        

            if($this->rs=$con->CacheExecute(KKS_CACHE_KILLLIST, $sql)){
            	$this->rarray_detail=$this->rs_detail->GetAssoc();
            } else {
            	trigger_error('SQL Query Failed', E_USER_ERROR);
            }
            
    }
}

?>