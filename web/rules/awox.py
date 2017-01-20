# awox.py
# Author: Valtyr Farshield
# Author: Tomas Bosek

from skeleton import Skeleton
from statsconfig import StatsConfig
from models.kill import Kill


class Awox(Skeleton):

    def __init__(self):
        self.json_file_name = "awoxes.json"
        self.kills = list()

    def sort(self):
        self.kills.sort(key=lambda x: x.value, reverse=True)

    def process_km(self, killmail):
        corporation_id = 0
        if killmail['victim']['corporationID'] in StatsConfig.CORP_IDS:
            agent_id = 0
            for attacker in killmail['attackers']:
                if attacker['finalBlow'] == 1:
                    agent_id = attacker['characterID']
            kill_id = killmail['killID']
            character_id = killmail['victim']['characterID']
            character_name = killmail['victim']['characterName']
            ship_type_id = killmail['victim']['shipTypeID']
            solar_system_id = killmail['solarSystemID']
            date = killmail['killTime']
            isk_destroyed = killmail['zkb']['totalValue']
            attackers = killmail['attackers']
            isOurLoss = 1
            isExplorer = 0
            corporation_id = killmail['victim']['corporationID']
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
