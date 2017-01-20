# kills.py
# Author: Valtyr Farshield
# Author: Tomas Bosek

from skeleton import Skeleton
from statsconfig import StatsConfig
from models.kill import Kill


class Kills(Skeleton):

    def __init__(self):
        self.json_file_name = "kills.json"
        self.kills = list()

    def sort(self):
        self.kills.sort(key=lambda x: x.value, reverse=True)

    def process_km(self, killmail):
        agent_id = 0
        

        for attacker in killmail['attackers']:
            if attacker['finalBlow'] == 1:
                agent_id = attacker['characterID']
        isOurLoss = 0
        if killmail['victim']['corporationID'] in StatsConfig.CORP_IDS:
            isOurLoss = 1
        kill_id = killmail['killID']
        character_id = killmail['victim']['characterID']
        character_name = killmail['victim']['characterName']
        corporation_id = killmail['victim']['corporationID']
        ship_type_id = killmail['victim']['shipTypeID']
        solar_system_id = killmail['solarSystemID']
        date = killmail['killTime']
        isk_destroyed = killmail['zkb']['totalValue']
        attackers = killmail['attackers']
        isExplorer = 0
        isBombing = 0
        for item in killmail['items']:
            if item['flag'] >= 19 and item['flag'] <= 26:  # midslots
                if item['typeID'] in [22177, 30832, 22175, 30834, 3581]:  # relic and data analyzers
                    isExplorer = 1
                    break
        self.kills.append(
            Kill(
                kill_id,
                character_id,
                character_name,
                ship_type_id,
                solar_system_id,
                date,
                isk_destroyed,
                agent_id,
                attackers,
                isExplorer,
                isOurLoss,
                corporation_id
            )
        )
