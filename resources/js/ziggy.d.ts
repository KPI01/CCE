/* This file is generated by Ziggy. */
declare module 'ziggy-js' {
  interface RouteList {
    "dusk.login": [
        {
            "name": "userId",
            "required": true
        },
        {
            "name": "guard",
            "required": false
        }
    ],
    "dusk.logout": [
        {
            "name": "guard",
            "required": false
        }
    ],
    "dusk.user": [
        {
            "name": "guard",
            "required": false
        }
    ],
    "sanctum.csrf-cookie": [],
    "telescope": [
        {
            "name": "view",
            "required": false
        }
    ],
    "ignition.healthCheck": [],
    "ignition.executeSolution": [],
    "ignition.updateConfig": [],
    "login": [],
    "login.usuario": [],
    "registro": [],
    "store.usuario": [],
    "verification.notice": [],
    "verification.verify": [
        {
            "name": "id",
            "required": true
        },
        {
            "name": "hash",
            "required": true
        }
    ],
    "verification.send": [],
    "password.request": [],
    "password.email": [],
    "password.reset": [
        {
            "name": "token",
            "required": true
        }
    ],
    "password.update": [],
    "logout": [],
    "home": [],
    "persona.index": [],
    "persona.create": [],
    "persona.store": [],
    "persona.show": [
        {
            "name": "persona",
            "required": true
        }
    ],
    "persona.edit": [
        {
            "name": "persona",
            "required": true
        }
    ],
    "persona.update": [
        {
            "name": "persona",
            "required": true
        }
    ],
    "persona.destroy": [
        {
            "name": "persona",
            "required": true
        }
    ],
    "empresa.index": [],
    "empresa.create": [],
    "empresa.store": [],
    "empresa.show": [
        {
            "name": "empresa",
            "required": true
        }
    ],
    "empresa.edit": [
        {
            "name": "empresa",
            "required": true
        }
    ],
    "empresa.update": [
        {
            "name": "empresa",
            "required": true
        }
    ],
    "empresa.destroy": [
        {
            "name": "empresa",
            "required": true
        }
    ],
    "maquina.index": [],
    "maquina.create": [],
    "maquina.store": [],
    "maquina.show": [
        {
            "name": "maquina",
            "required": true
        }
    ],
    "maquina.edit": [
        {
            "name": "maquina",
            "required": true
        }
    ],
    "maquina.update": [
        {
            "name": "maquina",
            "required": true
        }
    ],
    "maquina.destroy": [
        {
            "name": "maquina",
            "required": true
        }
    ]
}
}
export {};
