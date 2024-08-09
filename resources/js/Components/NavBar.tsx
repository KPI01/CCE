import {
  Menubar,
  MenubarContent,
  MenubarItem,
  MenubarMenu,
  MenubarSeparator,
  MenubarSub,
  MenubarSubContent,
  MenubarSubTrigger,
} from "./ui/menubar";
import { MenubarTrigger } from "@radix-ui/react-menubar";
import { LogOut, User2 } from "lucide-react";
import { Link, router, usePage } from "@inertiajs/react";
import { Button } from "./ui/button";
import { ReactElement } from "react";
import { v4 as uuidv4 } from "uuid";
import {
  EmpresaIcon,
  MaquinaIcon,
  PersonaIcon,
  RecursosIcon,
} from "@/Pages/Recursos/utils";
import { EmailIcon, HomeIcon, TablasAuxiliaresIcon } from "@/icons";

const MENUTRIGGER_CLASS =
  "w-max font-medium border-px flex items-center rounded border-accent px-2 py-1";
const MENUBARITEM_CLASS = "cursor-pointer w-full justify-start";
const BUTTON_CLASS = "w-full justify-Button";

interface MenuItemsProps {
  Icon: ReactElement;
  Texto: string;
  Recurso: string;
}
const recursos: MenuItemsProps[] = [
  {
    Icon: <PersonaIcon />,
    Texto: "Personas",
    Recurso: "persona",
  },
  {
    Icon: <EmpresaIcon />,
    Texto: "Empresas",
    Recurso: "empresa",
  },
  {
    Icon: <MaquinaIcon />,
    Texto: "Máquinas",
    Recurso: "maquina",
  },
];

interface handleRecursoLinkParams {
  recurso: string;
}

export default function NavBar() {
  const { auth }: any = usePage().props;
  const username = auth?.user?.name;
  const email = auth?.user?.email;
  const routeCurrent = route().current();
  const currentIsHome = routeCurrent === "home";

  function goHome() {
    router.get(route("home"));
  }

  function handleLogout() {
    router.post(route("logout"));
  }

  function handleRecursoLink({ recurso }: handleRecursoLinkParams) {
    const url = route(`${recurso}.index`);
    console.info("Redirigiendo a...", url);
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
            <HomeIcon />
            Dashboard
          </Button>
        )}
        <MenubarMenu>
          <MenubarTrigger id="action-recursos" className={MENUTRIGGER_CLASS}>
            <RecursosIcon />
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
                <EmailIcon />
                {email}
              </Button>
            </MenubarItem>
            <MenubarSeparator />
            <MenubarSub>
              <MenubarSubTrigger className={MENUBARITEM_CLASS}>
                <TablasAuxiliaresIcon />
                Tablas auxiliares
              </MenubarSubTrigger>
              <MenubarSubContent className="ml-2">
                <MenubarItem className={MENUBARITEM_CLASS} asChild>
                  <Link href={route("aux_maquina.index")}>
                    <MaquinaIcon />
                    Máquinas
                  </Link>
                </MenubarItem>
              </MenubarSubContent>
            </MenubarSub>
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
