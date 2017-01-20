from rules.statsconfig import StatsConfig
class Kill(object):
    def __init__(
        self,
        kill_id,
        character_id,
        character_name,
        ship_type_id,
        solar_system_id,
        date,
        value,
        agent_id,
        attackers,
        isExplorer = 0,
        isOurLoss = 0,
        corporation_id = 0 ): 
        self.kill_id = kill_id
        self.character_id = character_id
        self.character_name = character_name
        self.ship_type_id = ship_type_id
        self.solar_system_id = solar_system_id
        self.date = date
        self.value = value
        self.agent_id = agent_id
        self.attackers = []
        self.wingspanAgents = 0
        self.thirdParty = 0
        self.npc = 0
        self.totalDamage = 0
        self.isExplorer = isExplorer
        self.isOurLoss = isOurLoss
        self.corporation_id = corporation_id
        
        for a in attackers:
            data = None
            if a['factionID'] != 0: 
                self.npc = self.npc + 1
                a['is_agent'] = 0              
            elif a['corporationID'] in StatsConfig.CORP_IDS: 
                self.wingspanAgents = self.wingspanAgents + 1
                a['is_agent'] = 1
            else: 
                self.thirdParty = self.thirdParty + 1
                a['is_agent'] = 0
            self.totalDamage = self.totalDamage + a['damageDone']
            wasBombing = 0

            if a['characterID'] != 0:
                if a['weaponTypeID'] in [27916, 27920, 27918, 27912]:
                    wasBombing = 1
                data = {'killingBlow': a['finalBlow'],'character_id': a['characterID'],'character_name': a['characterName'],'corporation_id': a['corporationID'],'corporation_name':a['corporationName'],'ship_type_id':a['shipTypeID'],'damageDone':a['damageDone'],'is_agent': a['is_agent'],'wasBombing': wasBombing}                        

                self.attackers.insert(1,data)
        totalAgents =  self.wingspanAgents + self.thirdParty 
        # print "{} /{}".format(totalAgents,self.wingspanAgents) 
        if self.wingspanAgents > 0:
            self.totalWingspanPct = round( self.wingspanAgents / float(totalAgents),3)
        else:
            self.totalWingspanPct = 0
      

