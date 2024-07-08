const Ziggy = {
  url: "http://127.0.0.1:8000",
  port: 8000,
  defaults: {},
  routes: {
    "dusk.login": {
      uri: "_dusk/login/{userId}/{guard?}",
      methods: ["GET", "HEAD"],
      parameters: ["userId", "guard"],
    },
    "dusk.logout": {
      uri: "_dusk/logout/{guard?}",
      methods: ["GET", "HEAD"],
      parameters: ["guard"],
    },
    "dusk.user": {
      uri: "_dusk/user/{guard?}",
      methods: ["GET", "HEAD"],
      parameters: ["guard"],
    },
    "sanctum.csrf-cookie": {
      uri: "sanctum/csrf-cookie",
      methods: ["GET", "HEAD"],
    },
    "ignition.healthCheck": {
      uri: "_ignition/health-check",
      methods: ["GET", "HEAD"],
    },
    "ignition.executeSolution": {
      uri: "_ignition/execute-solution",
      methods: ["POST"],
    },
    "ignition.updateConfig": {
      uri: "_ignition/update-config",
      methods: ["POST"],
    },
    root: { uri: "/", methods: ["GET", "HEAD"] },
    login: { uri: "cce/auth/login", methods: ["GET", "HEAD"] },
    "login.usuario": { uri: "cce/auth/login", methods: ["POST"] },
    registro: { uri: "cce/auth/registro", methods: ["GET", "HEAD"] },
    "store.usuario": { uri: "cce/auth/registro", methods: ["POST"] },
    "verification.notice": {
      uri: "cce/auth/correo/validar",
      methods: ["GET", "HEAD"],
    },
    "verification.verify": {
      uri: "cce/auth/correo/validar/{id}/{hash}",
      methods: ["GET", "HEAD"],
      parameters: ["id", "hash"],
    },
    "verification.send": {
      uri: "cce/auth/correo/correo/notificaci\u00f3n",
      methods: ["POST"],
    },
    "password.request": {
      uri: "cce/auth/clave/olvido",
      methods: ["GET", "HEAD"],
    },
    "password.email": { uri: "cce/auth/clave/olvido", methods: ["POST"] },
    "password.reset": {
      uri: "cce/auth/clave/reseteo/{token}",
      methods: ["GET", "HEAD"],
      parameters: ["token"],
    },
    "password.update": { uri: "cce/auth/clave/reseteo", methods: ["POST"] },
    logout: { uri: "cce/auth/logout", methods: ["POST"] },
    home: { uri: "cce/app/home", methods: ["GET", "HEAD"] },
    "personas.index": {
      uri: "cce/app/recurso/personas",
      methods: ["GET", "HEAD"],
    },
    "personas.create": {
      uri: "cce/app/recurso/personas/create",
      methods: ["GET", "HEAD"],
    },
    "personas.store": { uri: "cce/app/recurso/personas", methods: ["POST"] },
    "personas.show": {
      uri: "cce/app/recurso/personas/{persona}",
      methods: ["GET", "HEAD"],
      parameters: ["persona"],
    },
    "personas.edit": {
      uri: "cce/app/recurso/personas/{persona}/edit",
      methods: ["GET", "HEAD"],
      parameters: ["persona"],
    },
    "personas.update": {
      uri: "cce/app/recurso/personas/{persona}",
      methods: ["PUT", "PATCH"],
      parameters: ["persona"],
    },
    "personas.destroy": {
      uri: "cce/app/recurso/personas/{persona}",
      methods: ["DELETE"],
      parameters: ["persona"],
    },
    "empresas.index": {
      uri: "cce/app/recurso/empresas",
      methods: ["GET", "HEAD"],
    },
    "empresas.create": {
      uri: "cce/app/recurso/empresas/create",
      methods: ["GET", "HEAD"],
    },
    "empresas.store": { uri: "cce/app/recurso/empresas", methods: ["POST"] },
    "empresas.show": {
      uri: "cce/app/recurso/empresas/{empresa}",
      methods: ["GET", "HEAD"],
      parameters: ["empresa"],
    },
    "empresas.edit": {
      uri: "cce/app/recurso/empresas/{empresa}/edit",
      methods: ["GET", "HEAD"],
      parameters: ["empresa"],
    },
    "empresas.update": {
      uri: "cce/app/recurso/empresas/{empresa}",
      methods: ["PUT", "PATCH"],
      parameters: ["empresa"],
    },
    "empresas.destroy": {
      uri: "cce/app/recurso/empresas/{empresa}",
      methods: ["DELETE"],
      parameters: ["empresa"],
    },
  },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
