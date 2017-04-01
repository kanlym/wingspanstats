<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\Cache\Cache;
/**
 * Monthstats Model
 *
 * @method \App\Model\Entity\Monthstat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monthstat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Monthstat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monthstat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Monthstat findOrCreate($search, callable $callback = null, $options = [])
 * 
 * must change stats for participating not last hit
 */
class StatsTable extends Table
{
    
    public $astero = array(33468);
    public $blops = array(22430, 22440, 22428, 22436);
    public $bombers = array(11377, 12034, 12032, 12038);
    public $caps = array(
                            19724, 34339, 19722, 34341, 19726, 34343, 19720, 34345,  # Dreads
                            23757, 23915, 24483, 23911,  # Carriers
                            37604, 37605, 37606, 37607,  # Force auxiliaries
                            23919, 22852, 3628, 23913, 3514, 23917,  # Supers
                            11567, 671, 3764, 23773 );
    public $industrials = array(
                                648, 1944, 33695, 655, 651, 33689, 657, 654,  # industrials
                                652, 33693, 656, 32811, 4363, 4388, 650, 2998,  # industrials
                                2863, 19744, 649, 33691, 653,  # industrials
                                12729, 12733, 12735, 12743,  # blockade runners
                                12731, 12753, 12747, 12745,  # deep space transports
                                34328, 20185, 20189, 20187, 20183,  # freighters
                                28848, 28850, 28846, 28844,  # jump freighters
                                28606, 33685, 28352, 33687,  # orca, rorq
            );
    public $interdictors = array(
                    22460, 22464, 22452, 22456,  # interdictors
                    12013, 12017, 11995, 12021,  # heavy interdictors
        );
    public $miners = array(
                        32880, 33697, 37135,  # mining frigates
                        17476, 17480, 17478,  # mining barges
                        22544, 22548, 33683, 22546,  # exhumers
                        42244, 28606                 #  porpoise & orca
        );
    public $nestor = array(33472);
    public $pod = array(670, 33328);
    public $recons = array(11969, 11957, 11965, 11963, 20125, 11961, 11971, 11959);
    public $stratios = array(33470);
    public $strategicCruiser = array(29986, 29990, 29988, 29984);
    public $citadels = array(

        );
    public $WDSCorps = array(98330748);
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('monthstats');
        $this->displayField('date');
        $this->primaryKey('statsname');
    }

    public function agents($dateStart = false,$dateEnd = false){

        $cacheKey = 'agents_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $wds = implode(',',$this->WDSCorps);
         $query = "SELECT 
            count(ak.kill_id) as kills, c.character_name,sum(value)/1000000000 as isk,c.character_id from agent_kills as ak join kills on kills.kill_id = ak.kill_id
            join characters as c on c.character_id = ak.character_id
            where date > '$dateStart 00:00:00'
            and date <= '$dateEnd 00:00:00'
            and totalWingspanPct > 24
            AND c.corporation_id in ($wds) 
           group by ak.`character_id`
            ORDER BY kills DESC";
                $connection = ConnectionManager::get('default');
                $results = $connection->execute($query)->fetchAll('assoc');
        $s = Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
      public function topLastSevenDays($de){
        $ds = date('Y-m-d',strtotime('-7 days'));
        
        $cacheKey = 'topLastSevenDaysXXX_' . $ds. '_'. $de;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        
         $query = "SELECT s.name,kills.value/1000000000 as v,kills.kill_id,partiesInvolved,totalWingspanPct from kills 
                    JOIN ship_types as s on kills.ship_type_id = s.ship_type_id

                    where totalWingspanPct > 25
                    AND date > '$ds 00:00:00'
                    AND date < '$de 23:59:59'
                    order by value DESC limit 10";
                $connection = ConnectionManager::get('default');
                $results = $connection->execute($query)->fetchAll('assoc');
                $output = array();
                foreach ($results as $r){
                    $o = array(
                            'kill'=>$r['kill_id'],
                            'ship'=>$r['name'],
                            'value'=>$r['v'],
                            'involved'=>round($r['partiesInvolved'] * $r['totalWingspanPct']/100) .' wingspan members out of ' . $r['partiesInvolved'] . ' total'
                        );
                    $output[] = $o; 
                }
        $s = Cache::write($cacheKey,$output,'fivemin');
        return $output;
    }

     public function ship($shipName = 'stratios',$dateStart = false,$dateEnd = false){
        $cacheKey = 'ships_' . $dateStart. '_'. $dateEnd. '_'.md5($shipName);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT count(ak.kill_id) as noOfKills,
                        sum(damageDone) as damageDone,
                        sum(value)/1000000000 as isk,
                        'billion' as currency,
                        a.character_name as agent
                        from agent_kills as ak 
                            join characters as a on a.character_id = ak.character_id 
                            join kills on kills.kill_id = ak.kill_id 
                            join ship_types as victimShip on victimShip.ship_type_id = kills.ship_type_id 
                            join ship_types as agentShip on agentShip.ship_type_id = ak.ship_type_id
                        where  
                            kills.date > '$dateStart 00:00:00' 
                        and kills.date <= '$dateEnd 00:00:00'
                        and agentShip.name = '$shipName'
                        and totalWingspanPct > 24
                        group by a.character_id
                        order by isk DESC
                        ";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        
        return $results;
    }

     public function pilots($pilotName = 'Kanly Aideron',$dateStart = false,$dateEnd = false){
        $cacheKey = 'pilots_' . $dateStart. '_'. $dateEnd. '_'.md5($pilotName);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        // solo
        // participated
        // loss
        $query = "SELECT count(ak.kill_id) as noOfKills,
            sum(ak.killingBlow) as killingShot,
            sum(damageDone) as damageDone,
            sum(value)/1000000000 as isk,
            'billion' as currency,
            agentShip.name as shipName
                 from 
                 agent_kills as ak 
                 join characters as a on a.character_id = ak.character_id 
                 join kills on kills.kill_id = ak.kill_id 
                 join ship_types as victimShip on victimShip.ship_type_id = kills.ship_type_id 
                 join ship_types as agentShip on agentShip.ship_type_id = ak.ship_type_id
            where character_name = '$pilotName'
            and kills.date > '$dateStart 00:00:00' 
            and kills.date <= '$dateEnd 00:00:00'
            and totalWingspanPct > 24
            -- and ak.killingBlow = 0
            group by ak.ship_type_id
            order by noOfKills DESC
                        ";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function locations($dateStart = false, $dateEnd = false){
        $cacheKey = 'locations_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT sum(value)/1000000000 as isk,count(kills.kill_id) as ships,system.type as system,isWh,'billion' as currency from kills
                 join solar_systems as system on system.solar_system_id = kills.solar_system_id

            where date > '$dateStart 00:00:00'  
            and date <= '$dateEnd 00:00:00'
            and totalWingspanPct > 24
            and isOurLoss = 0
            group by system.type
            ORDER BY isk DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        $output = array();//formating
        $totalWhIsk = 0;
        $totalWhKills = 0;
        $wh = array();
        $details = array();
        foreach ($results as $i=>$r){
             if ($r['isWh']){
                $totalWhIsk += $r['isk'];
                $totalWhKills += $r['ships'];
                $details[] = $r;
                unset($results[$i]);
             }

        }
        $wh['isk'] = $totalWhIsk;
        $wh['ships'] = $totalWhKills;
        $wh['system'] = 'WormHole';
        $wh['currency'] = 'billion';
        $wh['isWh'] = "1";
        $wh['details'] = $details;
        foreach ($results as $r){
            $output[] = $r;
        }
        $output['wh'] = $wh;
        Cache::write($cacheKey,$output,'fivemin');
        return $output;
    }

     public function solo($dateStart = false,$dateEnd = false){
        $cacheKey = 'solo_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $query = "SELECT sum(kills.value) /1000000000 as isk ,count(kills.kill_id) as ships_killed ,c.character_name,c.character_id
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where killingBlow = 1
                    and isOurLoss = 0
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    and partiesInvolved = 1
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function topKillInAstero($dateStart = false,$dateEnd = false){
        $cacheKey = 'topKillInAsteroC1_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $query = "select kills.kill_id,s.name as sname, characters.character_name, value/1000000000 as isk,ss.name from kills
                    JOIN ship_types as s on kills.ship_type_id = s.ship_type_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    JOIN characters on ak.character_id = characters.character_id
                    JOIN solar_systems as ss on ss.solar_system_id = kills.solar_system_id
                    where date > '$dateStart 00:00:00'
                    and date < '$dateEnd 00:00:00'
                    AND partiesInvolved = 1
                    AND totalWingspanPCT = 100
                    AND isOurLoss = false
                    AND ak.ship_type_id = 33468
                    AND ak.killingBlow = 1
                    AND ss.isWh = 1
                    ORDER BY VALUE DESC
                    LIMIT 1";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
        public function topKillInBomber($dateStart = false,$dateEnd = false){
        $cacheKey = 'topKillInBomber_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $bombers = implode(',',$this->bombers);
        $query = "select kills.kill_id,s.name as sname, characters.character_name, value/1000000000 as isk,ss.name,flying.name as flyingShip from kills
                    JOIN ship_types as s on kills.ship_type_id = s.ship_type_id
                    
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    JOIN ship_types as flying on ak.ship_type_id = flying.ship_type_id
                    JOIN characters on ak.character_id = characters.character_id
                    JOIN solar_systems as ss on ss.solar_system_id = kills.solar_system_id
                    where date > '$dateStart 00:00:00'
                    and date < '$dateEnd 00:00:00'
                    AND partiesInvolved = 1
                    AND totalWingspanPCT = 100
                    AND isOurLoss = false
                    AND ak.ship_type_id in ($bombers)
                    AND ak.killingBlow = 1
                    AND ss.isWh = 1
                    ORDER BY VALUE DESC
                    LIMIT 1";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
            public function topKillsinarecon($dateStart = false,$dateEnd = false){
        $cacheKey = 'topKillInRecon_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }        
        $recons = implode(',',$this->recons);
        $query = "select kills.kill_id,s.name as sname, characters.character_name, value/1000000000 as isk,ss.name,flying.name as flyingShip from kills
                    JOIN ship_types as s on kills.ship_type_id = s.ship_type_id
                    
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    JOIN ship_types as flying on ak.ship_type_id = flying.ship_type_id
                    JOIN characters on ak.character_id = characters.character_id
                    JOIN solar_systems as ss on ss.solar_system_id = kills.solar_system_id
                    where date > '$dateStart 00:00:00'
                    and date < '$dateEnd 00:00:00'
                    AND partiesInvolved = 1
                    AND totalWingspanPCT = 100
                    AND isOurLoss = false
                    AND ak.ship_type_id in ($recons)
                    AND ak.killingBlow = 1
                    AND ss.isWh = 1
                    ORDER BY VALUE DESC
                    LIMIT 1";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getGenericByFlownShip($ship = array(),$solo = 1, $dateStart = false, $dateEnd = false){

        $cacheKey = 'sgetGenericByFlownShip_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . md5(implode('_',$ship));
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }       
        $ships = implode(',',$ship);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }

          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying,c.character_id
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                     -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    and totalWingspanPct > 24
                    -- and isKillingBlows = 1 #FOR SOLO
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    and agntShip.ship_type_id in ($ships)      
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }       
    public function getGenericByDestroyedShip($ship = array(),$solo = 1, $dateStart = false, $dateEnd = false){
         $cacheKey = 'getGenericByDestroyedShip_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . md5(implode('_',$ship));
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $ships = implode(',',$ship);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying,c.character_id
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    and totalWingspanPct > 24
                    -- and isKillingBlows = 1 #FOR SOLO
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    and kills.ship_type_id in ($ships)      
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
     public function getExplorerKills($solo = 1, $dateStart = false, $dateEnd = false){
         $cacheKey = 'getExplorerKills' . $dateStart. '_'. $dateEnd . '_'. $solo;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $soloConditions = "  ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value) / 1000000000 as isk ,count(kills.kill_id) as kills ,c.character_name,c.character_id
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where
                    isExplorer = 1
                    -- and isKillingBlows = 1 #FOR SOLO
                    and isOurLoss = 0
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    $soloConditions
                    group by c.character_id
                    ORDER by kills DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
      public function getGenericShipFlownShipDestroyed($agntShip = array(),$vicShip = array(),$solo = 1, $dateStart = false, $dateEnd = false){
        $cacheKey = 'getGenericShipFlownShipDestroyed_' . $dateStart. '_'. $dateEnd . '_'. $solo .'_' . implode('_',$agntShip) .implode('_',$vicShips);
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $agntShips = implode(',',$agntShip);
        $vicShips = implode(',',$vicShip);
        $soloConditions = " and partiesInvolved > 1 ";
        if ($solo == 1){
            $soloConditions = " and partiesInvolved = 1 ";
        }
          $query = "SELECT sum(kills.value)/1000000000 as isk ,count(kills.kill_id ) as ships_killed ,c.character_name,agntShip.name as agentFlying,c.character_id
                    from kills 
                    join agent_kills as ak on kills.kill_id = ak.kill_id
                    -- join agent_kills as ak on kills.kill_id = ak.kill_id AND ak.character_id = kills.agent_id #### FOR SOLO
                    join characters as c on c.character_id = ak.character_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where isOurLoss = 0
                    -- and isKillingBlows = 1 #FOR SOLO
                    and totalWingspanPct > 24
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    and kills.ship_type_id in ($vicShips) 
                    and ak.ship_type_id in ($agntShips)     
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    
    public function getLosses($dateStart = false,$dateEnd = false){
        $cacheKey = 'getLosses_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        } 
        $query = "SELECT sum(kills.value)/1000000000 as isk,
    kills.character_id,c.character_name,c.character_id,ship.name,count(kills.kill_id) as kills from kills 
    join characters as c on c.character_id = kills.character_id
    join ship_types as ship on ship.ship_type_id = kills.ship_type_id
    where isOurLoss = 1
    and date > '$dateStart 00:00:00'
    and date <= '$dateEnd 00:00:00'    
    
    
    group by kills.character_id
    order by kills DESC;";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getBiggestLoss($dateStart = false,$dateEnd = false){
        $cacheKey = 'getBiggestLoss_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT kills.value/1000000000 as isk,
                    kills.character_id,c.character_name,ship.name,kills.kill_id,c.character_id from kills 
                    join characters as c on c.character_id = kills.character_id
                    join ship_types as ship on ship.ship_type_id = kills.ship_type_id
                    where isOurLoss = 1
                    and date > '$dateStart 00:00:00'
                    and date <= '$dateEnd 00:00:00'    
                    
                    order by isk DESC;";
         $connection = ConnectionManager::get('default');
        $data = $connection->execute($query)->fetchAll('assoc');
        // debug($data);die();
        $characters = array();
        foreach ($data as $d){
            $id = $d['character_id'];
            if (!isset($characters[$id]))
                { $characters[$id] = array(
                            'isk'=>$d['isk'],
                            'max'=>$d['isk'],
                            'character_name' => $d['character_name'],
                            'name'=>$d['name']
                            );
            }else{
                if ($d['isk'] > $characters[$id]['max'])
                     $characters[$id] = array('isk'=>$d['isk'],'max'=>$d['isk'],'character_name' => $d['character_name'],'name'=>$d['name']);
            }
        }
        $results = array();
        foreach ($characters as $c){
            $results[] = $c;
        }
        usort($results,'cmpISK');
        Cache::write($cacheKey,$data,'fivemin');
        return $results;
    }
    public function miniBlops( $dateStart = false, $dateEnd = false){
         $cacheKey = 'miniBlops_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT sum(kills.value) / 1000000000 as isk ,count(kills.kill_id) as ships_killed ,c.character_name,partiesInvolved,c.character_id
                    from kills join characters as c on c.character_id = kills.agent_id
                    join agent_kills as ak on kills.kill_id = ak.kill_id and ak.character_id = kills.agent_id
                    join ship_types as vicShip on vicShip.ship_type_id = kills.ship_type_id
                    join ship_types as agntShip on agntShip.ship_type_id = ak.ship_type_id
                    where  partiesInvolved < 5
                    and totalWingspanPct > 24
                    and isOurLoss = 0
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                    and agntShip.ship_type_id in ($ships)
                    group by c.character_id
                    ORDER by ships_killed DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getAverageDestroyed( $dateStart = false, $dateEnd = false){
        $cacheKey = 'getAverageDestroyed_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT 
                    kills.value/1000000000 /  count(kills.kill_id)  as efficency,
                    count(kills.kill_id) as shipsDestroyed,
                    avg(kills.value)/1000000000 as avgValue,
                    kills.value/1000000000 as totalValue,
                    c.character_name,
                    c.character_id
                FROM kills
                    JOIN characters as c on c.character_id = kills.agent_id
                WHERE 
                    isOurLoss = 0
                    and totalWingspanPct > 24
                    and c.character_id > 0
                    and kills.date > '$dateStart 00:00:00'
                    and kills.date <= '$dateEnd 00:00:00'
                GROUP BY c.character_id
                ORDER BY efficency DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function averageIskPerKill( $dateStart = false, $dateEnd = false){
        $cacheKey = 'getAverageDestroyed_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT 
                    sum(kills.value / partiesInvolved * totalWingspanPct/100) / 1000000000 as isk,
                    sum(damageDone) / count(kills.kill_id) as averageDamageDone,
                    count(kills.kill_id) as noOfKills,
                    avg(partiesInvolved) as avgFleet,
                    c.character_name,
                    c.character_id
                    from agent_kills as ak 
                    JOIN kills on kills.kill_id = ak.kill_id
                    JOIN characters as c on c.character_id = ak.character_id
                WHERE 
                    isOurLoss = 0
                    AND date > '$dateStart 00:00:00'
                    AND date <= '$dateEnd 00:00:00'
                    AND totalWingspanPct > 24
                    and c.corporation_id in (98330748)
                    GROUP BY ak.character_id
                    ORDER BY isk DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function getAverageLost( $dateStart = false, $dateEnd = false){
         $cacheKey = 'getAverageLost_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT 
                        kills.value/1000000000 /  count(kills.kill_id)  as efficency,
                        count(kills.kill_id) as shipsDestroyed,
                        avg(kills.value)/1000000000 as avgValue,
                        kills.value/1000000000 as totalValue,
                        c.character_name,
                        c.character_id
                    FROM kills
                        JOIN characters as c on c.character_id = kills.character_id
                    WHERE 
                        isOurLoss = 1
                        and c.character_id > 0
                        and kills.date > '$dateStart 00:00:00'
                        and kills.date <= '$dateEnd 00:00:00'
                    GROUP BY c.character_id
                    ORDER BY efficency DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }  
    public function topShips( $dateStart = false, $dateEnd = false){
         $cacheKey = 'topShips_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT sum(kills.value)/1000000000 as isk, count(kills.kill_id) as totalKills, ship.name from agent_kills as ak
                        join kills on kills.kill_id = ak.kill_id
                        join ship_types as ship on ship.ship_type_id = ak.ship_type_id
                    WHERE 
                        kills.isOurLoss = 0
                        and totalWingspanPct >24
                        and kills.date > '$dateStart 00:00:00'
                        and kills.date <= '$dateEnd 00:00:00'
                        and ship.ship_type_id not in (0,670,33328)
                    GROUP BY ship.ship_type_id
                    ORDER BY isk DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
         Cache::write($cacheKey,$results,'fivemin');
        return $results;
    }
    public function tripwireMonth( $dateStart = false, $dateEnd = false){
       $cacheKey = 'tripwireMonth_' . $dateStart. '_'. $dateEnd;
        if (($output = Cache::read($cacheKey,'fivemin')) !== false){
            if (!empty($output)) return $output;
        }
        $ships = implode(',',$this->blops);
       
          $query = "SELECT c.character_name,
                            c.character_id,
                            sum(sigCount) as sigCount,
                            sum(systemsVisited) as systemsVisited,
                            sum(systemsViewed) as systemsViewed 
                    FROM tripwirestats 
                        join characters as c on c.character_id = tripwirestats.character_id
                    WHERE 
                        tripwirestats.date > '$dateStart 00:00:00'
                        and tripwirestats.date <= '$dateEnd 00:00:00'
                    GROUP BY c.character_id
                    ORDER BY systemsVisited DESC";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
         Cache::write($cacheKey,$results,'fivemin');

        return $results;
    }     
    public function getAllAgents(){
        $cacheKey = 'getAllAgents';
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
          $query = "SELECT c.character_name, c.character_id, corp.corporation_name from characters as c join corporations as corp on corp.corporation_id = c.corporation_id where  c.corporation_id in (98330748) and c.character_id > 0";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'eternity');
        return $results;
    }
    public function getClientByName($name = false){
        $cacheKey = 'getClientByName_' . md5($name);    
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
        $name = "%".str_replace(" ","%",$name)."%";
          $query = "SELECT c.character_name, c.character_id from characters as c  where  
           -- c.corporation_id not in (98330748) and 
           c.character_id > 0
           AND c.character_name like '$name'";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'eternity');
        return $results;
    }
    public function getInitialStats($cid = 0){
        $cacheKey = 'getInitialStats_' . $cid;
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
          $query = "SELECT sum(sigCount) as sigCount,sum(systemsVisited) as systemsVisited, sum(systemsViewed) as systemsViewed, character_id from tripwirestats where character_id = $cid ";
        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        Cache::write($cacheKey,$results,'eternity');

        return $results;
    }
    public function checkUserExistsForAuth($cid = 0){
        $cacheKey = 'checkUserExistsForAuth_' . $cid;
        if ($cid == 0) return false;

        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
        $query = "SELECT count(character_id) as character_id from characters where character_id = $cid ";

        $connection = ConnectionManager::get('default');
        $results = $connection->execute($query)->fetchAll('assoc');
        if (empty($results)) $results = false;
        Cache::write($cacheKey,$results,'eternity');
        return $results;
    }   
    //$query = "select * from tripwirestats where character_id = 92805979 and date = 0"; //get delta
    public function getDataByAgent($cid = 0,$dateStart = false,$dateEnd = false){
        $cacheKey = 'getAllAgents_' . strtotime($dateStart). '_' . strtotime($dateEnd). '_' . $cid;
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
        $results = array(
            'losses'=>array(),
            'killingBlows'=>array(),
            'favoriteShips'=>array(),
            'tripwire'=>array(),
            'kills'=>array(),
            'averages'=>array(),
            'favSystems'=>array()
            );

        $connection = ConnectionManager::get('default');
          $query = "SELECT vic.character_name, ship.name,k.date, k.value/1000000000 as value, k.totalWingspanPct, k.partiesInvolved, k.isExplorer,agnt.character_name,k.kill_id
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN characters as agnt on agnt.character_id = k.agent_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                where k.character_id = $cid 
                and k.date > '$dateStart 00:00:00'
                and k.date <= '$dateEnd 00:00:00'
                and isOurLoss = 1;";
        
        $losses = $connection->execute($query)->fetchAll('assoc');
        $query ="SELECT vic.character_name, ship.name,k.date, k.value /1000000000 as value, k.totalWingspanPct, k.partiesInvolved, k.isExplorer,agnt.character_name,k.kill_id
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN characters as agnt on agnt.character_id = k.agent_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                where agnt.character_id = $cid 
                and k.date > '$dateStart 00:00:00'
                and k.date <= '$dateEnd 00:00:00'
                and isOurLoss = 0;";
        $killingBlows = $connection->execute($query)->fetchAll('assoc');
        $query = "SELECT count(agentShip.ship_type_id) as noOfHits,sum(k.value)/1000000000 as value, agentShip.name
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN agent_kills as agents on agents.kill_id = k.kill_id
                JOIN characters as agnt on agnt.character_id = agents.character_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                JOIN ship_types as agentShip on agentShip.ship_type_id = agents.ship_type_id
                where agnt.character_id = $cid
                and k.date > '$dateStart 00:00:00'
                and k.date <= '$dateEnd 00:00:00'
                and isOurLoss = 0
                Group by agentShip.ship_type_id
                ORDER BY noOfHits DESC";
        $favoriteShip = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT sum(sigCount) as sigCountT, sum(systemsVisited) as systemsVisitedT, sum(systemsViewed) as systemsViewedT from tripwirestats where character_id = $cid
                and date > '$dateStart 00:00:00'
                and date <= '$dateEnd 00:00:00'
                ";
        $tripwireStats = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT  agentShip.name,value/1000000000 as value, ship.name as vicShip,damageDone,totalWingspanpct,partiesInvolved,k.kill_id
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN agent_kills as agents on agents.kill_id = k.kill_id
                JOIN characters as agnt on agnt.character_id = agents.character_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                JOIN ship_types as agentShip on agentShip.ship_type_id = agents.ship_type_id
                where agnt.character_id = $cid
                and k.date > '$dateStart 00:00:00'
                and k.date <= '$dateEnd 00:00:00'
                and isOurLoss = 0";

        $killsParticipated = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT 
                    sum(kills.value / partiesInvolved * totalWingspanPct/100) / 1000000000 as isk,
                    sum(damageDone) / count(kills.kill_id) as averageDamageDone,
                    count(kills.kill_id) as noOfKills,
                    avg(partiesInvolved) as avgFleet,
                    c.character_name,
                    c.character_id
                    from agent_kills as ak 
                    JOIN kills on kills.kill_id = ak.kill_id
                    JOIN characters as c on c.character_id = ak.character_id
                WHERE 
                    isOurLoss = 0
                    AND date > '$dateStart 00:00:00'
                    AND date <= '$dateEnd 00:00:00'
                    AND totalWingspanPct > 24
                    and c.corporation_id in (98330748)
                    and ak.character_id = $cid
                    ORDER BY isk DESC
        ";        
        $averages = $connection->execute($query)->fetchAll('assoc');
        $query = "SELECT 
                    count(k.kill_id) as noOfKills,
                    sum(value)/1000000000 as isk,
                    ss.name,
                    ss.isWh,
                    c.character_name
                    from agent_kills as ag
                    JOIN kills as k on k.kill_id = ag.kill_id
                    JOIN solar_systems as ss on ss.solar_system_id = k.solar_system_id
                    JOIN characters as c on c.character_id = ag.character_id
                WHERE
                    isOurLoss = 0
                    AND k.date > '$dateStart 00:00:00'
                    AND k.date <= '$dateEnd 00:00:00'
                    AND c.character_id = $cid
                GROUP BY ag.character_id, k.solar_system_id
                ORDER BY noOfKills DESC";
        $favSystems = $connection->execute($query)->fetchAll('assoc');
         $results = array(
            'losses'=>$losses,
            'killingBlows'=>$killingBlows,
            'favoriteShips'=>$favoriteShip,
            'tripwire'=>$tripwireStats,
            'kills'=>$killsParticipated,
            'averages'=>$averages,
            'favSystems'=>$favSystems
            );
        Cache::write($cacheKey,$results,'eternity');

        return $results;
    } 
    public function getClientById($cid = 0,$dateStart = false,$dateEnd = false){
        $cacheKey = 'getClientById_' . strtotime($dateStart). '_' . strtotime($dateEnd). '_' . $cid;
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
        $results = array(
            'losses'=>array(),
            'killingBlows'=>array(),
            'favoriteShips'=>array(),
            'tripwire'=>array(),
            'kills'=>array(),
            'averages'=>array(),
            'favSystems'=>array()
            );

        $connection = ConnectionManager::get('default');
          $query = "SELECT vic.character_name, ship.name,k.date, k.value/1000000000 as value, k.totalWingspanPct, k.partiesInvolved, k.isExplorer,agnt.character_name,k.kill_id,k.date
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN characters as agnt on agnt.character_id = k.agent_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                where k.character_id = $cid 
                ORDER BY k.date DESC
                ;";
        
        $losses = $connection->execute($query)->fetchAll('assoc');
        $query ="SELECT vic.character_name, ship.name,k.date, k.value /1000000000 as value, k.totalWingspanPct, k.partiesInvolved, k.isExplorer,agnt.character_name,k.date
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN characters as agnt on agnt.character_id = k.agent_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                where agnt.character_id = $cid 
                ORDER BY k.date DESC
                ;";
        $killingBlows = $connection->execute($query)->fetchAll('assoc');
        $query = "SELECT count(agentShip.ship_type_id) as noOfHits,sum(k.value)/1000000000 as value, agentShip.name
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN agent_kills as agents on agents.kill_id = k.kill_id
                JOIN characters as agnt on agnt.character_id = agents.character_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                JOIN ship_types as agentShip on agentShip.ship_type_id = agents.ship_type_id
                where agnt.character_id = $cid
                Group by agentShip.ship_type_id
                ORDER BY noOfHits DESC";
        $favoriteShip = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT sum(sigCount) as sigCountT, sum(systemsVisited) as systemsVisitedT, sum(systemsViewed) as systemsViewedT from tripwirestats where character_id = $cid
                and date > '$dateStart 00:00:00'
                and date <= '$dateEnd 00:00:00'
                ";
        $tripwireStats = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT  agentShip.name,value/1000000000 as value, ship.name as vicShip,damageDone,totalWingspanpct,partiesInvolved
                from kills  as k
                JOIN characters as vic on vic.character_id = k.character_id
                JOIN agent_kills as agents on agents.kill_id = k.kill_id
                JOIN characters as agnt on agnt.character_id = agents.character_id
                JOIN ship_types as ship on ship.ship_type_id = k.ship_type_id
                JOIN ship_types as agentShip on agentShip.ship_type_id = agents.ship_type_id
                where agnt.character_id = $cid
                ORDER BY k.date DESC
                ";

        $killsParticipated = $connection->execute($query)->fetchAll('assoc');

        $query = "SELECT 
                    sum(kills.value / partiesInvolved * totalWingspanPct/100) / 1000000000 as isk,
                    sum(damageDone) / count(kills.kill_id) as averageDamageDone,
                    count(kills.kill_id) as noOfKills,
                    avg(partiesInvolved) as avgFleet,
                    c.character_name,
                    c.character_id
                    from agent_kills as ak 
                    JOIN kills on kills.kill_id = ak.kill_id
                    JOIN characters as c on c.character_id = ak.character_id
                WHERE 
                  
                    c.corporation_id NOT in (98330748)
                    and ak.character_id = $cid
                    ORDER BY isk DESC
        ";        
        $averages = $connection->execute($query)->fetchAll('assoc');
        $query = "SELECT 
                    count(k.kill_id) as noOfKills,
                    sum(value)/1000000000 as isk,
                    ss.name,
                    ss.isWh,
                    c.character_name
                    from agent_kills as ag
                    JOIN kills as k on k.kill_id = ag.kill_id
                    JOIN solar_systems as ss on ss.solar_system_id = k.solar_system_id
                    JOIN characters as c on c.character_id = ag.character_id
                WHERE
                     c.character_id = $cid
                GROUP BY ag.character_id, k.solar_system_id
                ORDER BY noOfKills DESC";
                // debug($query);die();
        $favSystems = $connection->execute($query)->fetchAll('assoc');
         $results = array(
            'losses'=>$losses,
            'killingBlows'=>$killingBlows,
            'favoriteShips'=>$favoriteShip,
            'tripwire'=>$tripwireStats,
            'kills'=>$killsParticipated,
            'averages'=>$averages,
            'favSystems'=>$favSystems
            );
        Cache::write($cacheKey,$results,'eternity');

        return $results;
    } 
    public function getFavoriteSystems($dateStart = false,$dateEnd = false){
        $cacheKey = 'getFavoriteSystems_' . strtotime($dateStart) .'_'.strtotime($dateEnd);
        if (($output = Cache::read($cacheKey,'eternity')) !== false){
            if (!empty($output)) return $output;
        }
        $results = array(
                'fav'=>array(),
                'welp'=>array()
            );
          $query = "SELECT 
                    count(k.kill_id) as noOfKills,
                    sum(value)/1000000000 as isk,
                    ss.name,
                    ss.isWh
                FROM kills as k 
                    JOIN solar_systems as ss on ss.solar_system_id = k.solar_system_id
                WHERE
                    isOurLoss = 0
                    AND totalWingspanpct >= 25
                    AND k.date > '$dateStart 00:00:00'
                    AND k.date <= '$dateEnd 00:00:00'
                GROUP BY k.solar_system_id
                ORDER BY noOfKills DESC";
                // debug($query);die()
        $connection = ConnectionManager::get('default');
        $favoriteLocation = $connection->execute($query)->fetchAll('assoc');
        $query = "SELECT 
                    count(k.kill_id) as noOfKills,
                    sum(value)/1000000000 as isk,
                    ss.name,
                    ss.isWh
                FROM kills as k 
                    JOIN solar_systems as ss on ss.solar_system_id = k.solar_system_id
                WHERE
                    isOurLoss = 1
                    AND k.date > '$dateStart 00:00:00'
                    AND k.date <= '$dateEnd 00:00:00'
                GROUP BY k.solar_system_id
                ORDER BY noOfKills DESC";
        $welpLocation = $connection->execute($query)->fetchAll('assoc');
        $results = array(
                'fav'=>$favoriteLocation,
                'welp'=>$welpLocation
            );
        Cache::write($cacheKey,$results,'eternity');
        return $results;
    } 
    public function addToQueue($name){
        $query = "INSERT INTO `characterques` (`character_id`, `character_name`, `queued`)
            VALUES
                (0, '$name', '".date('Y-m-d H:i:s')."');
            ";
                    $connection = ConnectionManager::get('default');
        $connection->execute($query);
        return true;
    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('date', 'create');

        $validator
            ->requirePresence('statsname', 'create')
            ->notEmpty('statsname');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        return $validator;
    }
}
