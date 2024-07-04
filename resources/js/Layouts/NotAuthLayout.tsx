import NavBar from "@/Components/NoAuth/NavBar";

import { PropsWithChildren } from "react";

interface Routes {
  [key: string]: {
    text: string;
    uri: string;
  };
}

export default function NoAuthLayout({ children }: PropsWithChildren) {
  const uri: string | "" = route().current()?.toString() || "";
  const routes: Routes = {
    login: {
      text: "Regístrate",
      uri: "registro",
    },
    registro: {
      text: "Iniciar sesión",
      uri: "login",
    },
    "verification.notice": {
      text: "Cerrar sesión",
      uri: "logout",
    },
    "password.request": {
      text: "Volver al inicio de sesión",
      uri: "login",
    },
  };

  // console.log('vars:', `uri: ${uri}`)

  return (
    <>
      <NavBar uri={routes[uri]?.uri} txt={routes[uri]?.text} />
      <main className="grid basis-full place-content-center">{children}</main>
    </>
  );
}
