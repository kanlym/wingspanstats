# capitals.py
# Author: Valtyr Farshield
# Author: Tomas Bosek

from skeleton import Skeleton
from statsconfig import StatsConfig
from models.kill import Kill


class Capitals(Skeleton):

    def __init__(self):
        self.json_file_name = "capital_kills.json"
        self.kills = list()

    def sort(self):
        self.kills.sort(key=lambda x: x.value, reverse=True)

    def process_km(self, killmail):
        kill_id = killmail['killID']
        character_id = killmail['victim']['characterID']
        character_name = killmail['victim']['characterName']
        ship_type_id = killmail['victim']['shipTypeID']
        solar_system_id = killmail['solarSystemID']
        date = killmail['killTime']
        isk_destroyed = killmail['zkb']['totalValue']
        corporation_id = killmail['victim']['corporationID']
        agent_id = 0
        isExplorer = 0
        isOurLoss = 0
        if killmail['victim']['corporationID'] in StatsConfig.CORP_IDS:
            isOurLoss = 1
        if ship_type_id in [
            19724, 34339, 19722, 34341, 19726, 34343, 19720, 34345,  # Dreads
            23757, 23915, 24483, 23911,  # Carriers
            37604, 37605, 37606, 37607,  # Force auxiliaries
            23919, 22852, 3628, 23913, 3514, 23917,  # Supers
            11567, 671, 3764, 23773,  # Titans
        ]:
            attackers = killmail['attackers']
            for attacker in killmail['attackers']:
                if attacker['finalBlow'] == 1:
                    agent_id = attacker['characterID']
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
