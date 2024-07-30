const Ziggy = {"url":"http:\/\/127.0.0.1:8000","port":8000,"defaults":{},"routes":{"dusk.login":{"uri":"_dusk\/login\/{userId}\/{guard?}","methods":["GET","HEAD"],"parameters":["userId","guard"]},"dusk.logout":{"uri":"_dusk\/logout\/{guard?}","methods":["GET","HEAD"],"parameters":["guard"]},"dusk.user":{"uri":"_dusk\/user\/{guard?}","methods":["GET","HEAD"],"parameters":["guard"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"telescope":{"uri":"telescope\/{view?}","methods":["GET","HEAD"],"wheres":{"view":"(.*)"},"parameters":["view"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"login":{"uri":"auth\/login","methods":["GET","HEAD"]},"login.usuario":{"uri":"auth\/login","methods":["POST"]},"registro":{"uri":"auth\/registro","methods":["GET","HEAD"]},"store.usuario":{"uri":"auth\/registro","methods":["POST"]},"verification.notice":{"uri":"auth\/correo\/validar","methods":["GET","HEAD"]},"verification.verify":{"uri":"auth\/correo\/validar\/{id}\/{hash}","methods":["GET","HEAD"],"parameters":["id","hash"]},"verification.send":{"uri":"auth\/correo\/correo\/notificaci\u00f3n","methods":["POST"]},"password.request":{"uri":"auth\/clave\/olvido","methods":["GET","HEAD"]},"password.email":{"uri":"auth\/clave\/olvido","methods":["POST"]},"password.reset":{"uri":"auth\/clave\/reseteo\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.update":{"uri":"auth\/clave\/reseteo","methods":["POST"]},"logout":{"uri":"auth\/logout","methods":["POST"]},"home":{"uri":"app\/home","methods":["GET","HEAD"]},"personas.index":{"uri":"app\/recurso\/personas","methods":["GET","HEAD"]},"personas.create":{"uri":"app\/recurso\/personas\/create","methods":["GET","HEAD"]},"personas.store":{"uri":"app\/recurso\/personas","methods":["POST"]},"personas.show":{"uri":"app\/recurso\/personas\/{persona}","methods":["GET","HEAD"],"parameters":["persona"]},"personas.edit":{"uri":"app\/recurso\/personas\/{persona}\/edit","methods":["GET","HEAD"],"parameters":["persona"]},"personas.update":{"uri":"app\/recurso\/personas\/{persona}","methods":["PUT","PATCH"],"parameters":["persona"]},"personas.destroy":{"uri":"app\/recurso\/personas\/{persona}","methods":["DELETE"],"parameters":["persona"]},"empresas.index":{"uri":"app\/recurso\/empresas","methods":["GET","HEAD"]},"empresas.create":{"uri":"app\/recurso\/empresas\/create","methods":["GET","HEAD"]},"empresas.store":{"uri":"app\/recurso\/empresas","methods":["POST"]},"empresas.show":{"uri":"app\/recurso\/empresas\/{empresa}","methods":["GET","HEAD"],"parameters":["empresa"]},"empresas.edit":{"uri":"app\/recurso\/empresas\/{empresa}\/edit","methods":["GET","HEAD"],"parameters":["empresa"]},"empresas.update":{"uri":"app\/recurso\/empresas\/{empresa}","methods":["PUT","PATCH"],"parameters":["empresa"]},"empresas.destroy":{"uri":"app\/recurso\/empresas\/{empresa}","methods":["DELETE"],"parameters":["empresa"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
