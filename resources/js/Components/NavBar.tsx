import { NavbarProps } from "@/types";
import {
  Menubar,
  MenubarContent,
  MenubarItem,
  MenubarMenu,
  MenubarSeparator,
} from "./ui/menubar";
import { MenubarTrigger } from "@radix-ui/react-menubar";
import {
  AtSign,
  Box,
  Building,
  Home,
  LogOut,
  Table2,
  User2,
  UserRound,
} from "lucide-react";
import { Link, router, usePage } from "@inertiajs/react";
import { Button } from "./ui/button";
import { ReactElement } from "react";
import { v4 as uuidv4 } from "uuid";

const MENUTRIGGER_CLASS =
  "w-max font-medium border-px flex items-center rounded border-accent px-2 py-1";
const MENUBARITEM_CLASS = "cursor-pointer w-full justify-start";
const BUTTON_CLASS = "w-full justify-Button";
const ICON_CLASS = "size-4 mr-2";

interface MenuItemsProps {
  Icon: ReactElement;
  Texto: string;
  Recurso: string;
  Ref?: string;
}
const recursos: MenuItemsProps[] = [
  {
    Icon: <UserRound className={ICON_CLASS} />,
    Texto: "Personas",
    Recurso: "persona",
    Ref: route("persona.index"),
  },
  {
    Icon: <Building className={ICON_CLASS} />,
    Texto: "Empresas",
    Recurso: "empresa",
    Ref: route("empresa.index"),
  },
];

interface handleRecursoLinkParams {
  recurso: string;
  accion?: "index";
}

export default function NavBar() {
  const { auth }: any = usePage().props;
  const username = auth?.user?.name;
  const email = auth?.user?.email;
  const routeCurrent = route().current();
  const currentIsHome = routeCurrent === "home";
  console.debug(`${routeCurrent} === "home" =>`, currentIsHome);

  function goHome() {
    console.warn("Dirigiendo al dashboard...");
    router.get(route("home"));
  }

  function handleLogout() {
    console.warn("Cerrando sesión...");
    router.post(route("logout"));
  }

  function handleRecursoLink({
    recurso,
    accion = "index",
  }: handleRecursoLinkParams) {
    const url = route(`${recurso}.${accion}`);
    console.debug("Redirigiendo a...", url);

    router.get(url);
  }

  return (
    <nav id="navbar" role="navigation" className="w-full py-2">
      <Menubar
        id="navbar-comp"
        className="mx-auto flex w-fit justify-center gap-6 bg-primary px-6 text-accent"
      >
        {!currentIsHome && (
          <Button
            id="action-home"
            className="w-max hover:bg-accent/0 hover:text-accent/75"
            size={"sm"}
            variant={"ghost"}
            onClick={() => goHome()}
          >
            <Home className={ICON_CLASS} />
            Dashboard
          </Button>
        )}
        <MenubarMenu>
          <MenubarTrigger id="action-recursos" className={MENUTRIGGER_CLASS}>
            <Box className={ICON_CLASS} />
            Recursos
          </MenubarTrigger>
          <MenubarContent id="content-recursos">
            {recursos.map((item) => {
              return (
                <MenubarItem
                  key={uuidv4()}
                  className={MENUBARITEM_CLASS}
                  asChild
                >
                  <Button
                    variant={"ghost"}
                    onClick={() => handleRecursoLink({ recurso: item.Recurso })}
                  >
                    {item.Icon}
                    {item.Texto}
                  </Button>
                </MenubarItem>
              );
            })}
          </MenubarContent>
        </MenubarMenu>
        <MenubarMenu>
          <MenubarTrigger id="action-config" className={MENUTRIGGER_CLASS}>
            <User2 className="mr-2 size-4" />
            {username}
          </MenubarTrigger>
          <MenubarContent id="content-config">
            <MenubarItem className={MENUBARITEM_CLASS} asChild>
              <Button className={BUTTON_CLASS} variant={"ghost"}>
                <AtSign className="mr-2 size-4" />
                {email}
              </Button>
            </MenubarItem>
            <MenubarSeparator />
            <MenubarItem className={MENUBARITEM_CLASS} asChild>
              <Button className={BUTTON_CLASS} variant={"ghost"} asChild>
                <Link href="#">
                  <Table2 className={ICON_CLASS} />
                  Tablas auxiliares
                </Link>
              </Button>
            </MenubarItem>
            <MenubarSeparator />
            <MenubarItem className={MENUBARITEM_CLASS} asChild>
              <Button
                className={BUTTON_CLASS}
                variant={"ghost"}
                onClick={handleLogout}
              >
                <LogOut className="mr-3 size-4" />
                Cerrar sesión
              </Button>
            </MenubarItem>
          </MenubarContent>
        </MenubarMenu>
      </Menubar>
    </nav>
  );
}
