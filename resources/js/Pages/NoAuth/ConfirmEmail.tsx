import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Button } from "@/Components/ui/button";
import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
} from "@/Components/ui/card";

import { Head, router } from "@inertiajs/react";

export default function ConfirmEmail() {
  function resendCode() {
    console.log("Reenviar código");

    // POST con router de Inertia
    router.post(route("verification.send"));
  }

  function handleContinue() {
    console.log("Cierre de sesión");

    router.get(route("dashboard.usuario"));
  }

  return (
    <NoAuthLayout>
      <Head title="Confirmación de correo" />

      <Card className="max-w-md">
        <CardHeader>
          <CardTitle>Confirma tu correo</CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <CardDescription>
            Para poder iniciar sesión, primero debes ingresar al link que ha
            sido enviado a tu correo. Una vez des click en el botón de
            verificar, puedes cerrar esta pestaña o volver del email y dar en
            "Continuar"
          </CardDescription>
          <Button id="continue-btn" className="me-5" onClick={handleContinue}>
            Continuar
          </Button>
          <Button id="resend-btn" onClick={resendCode} variant={"outline"}>
            Reenviar correo
          </Button>
        </CardContent>
      </Card>
    </NoAuthLayout>
  );
}
