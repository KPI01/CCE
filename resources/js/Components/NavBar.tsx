import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
  DropdownMenuSub,
  DropdownMenuSubTrigger,
  DropdownMenuSubContent,
  DropdownMenuPortal,
} from "@/Components/ui/dropdown-menu";
import {
  NavigationMenu,
  NavigationMenuContent,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  NavigationMenuTrigger,
} from "@/Components/ui/navigation-menu";
import { Button } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import { cn } from "@/lib/utils";

import { forwardRef } from "react";
import { Link } from "@inertiajs/react";
import { CircleHelp, Cog, LogOut, LucideHome, Menu, Pen } from "lucide-react";
import { NavbarProps } from "@/types";

const MENUCONTENT_CLASS =
  "p-4 h-fit grid gap-3 p-6 md:w-[35rem] lg:w-[45rem] lg:grid-cols-[.75fr_1fr]";

interface Resources {
  title: string;
  rsrc: string;
  href?: string;
  descrip?: string;
}

const config: Resources[] = [
  {
    title: "Usuarios",
    rsrc: "user",
    href: "#",
    descrip:
      "Administrar los usuarios existentes en la app. Diferente de personas",
  },
  {
    title: "Roles",
    rsrc: "roles",
    href: "#",
    descrip:
      "Administrar los roles de la app para garantizar/remover permisos.",
  },
];

const recursos: Resources[] = [
  {
    title: "Personas",
    rsrc: "persona",
    href: route("personas.index"),
    descrip:
      "Que se encuentren relacionadas con parcelas, empresas, tratamientos, etc...",
  },
  {
    title: "Empresas",
    rsrc: "empresa",
    href: route("empresas.index"),
    descrip:
      "Que realiza tratamientos, se encarga de parcelas, posee máquinas, etc...",
  },
  {
    title: "Productos",
    rsrc: "producto",
    href: "#",
  },
  {
    title: "Cultivos",
    rsrc: "cultivo",
    href: "#",
    descrip: "Diferentes cultivos que pueden asignarse a las parcelas.",
  },
];

export default function NavBar({ username, email, isAdmin }: NavbarProps) {
  const currentRoute = route().current()?.toString();
  console.log(currentRoute);
  return (
    <nav
      id="navbar"
      role="navigation"
      className="basis-auto px-7 py-4 pb-0 flex flex-col gap-3"
    >
      <div className="flex items-center justify-center gap-3">
        {!currentRoute?.includes("home") && (
          <>
            <Button variant={"ghost"} size={"sm"} asChild>
              <Link href={route("home")}>
                <LucideHome className="h-4" />
              </Link>
            </Button>
            <Separator orientation="vertical" className="h-[3ch]" />
          </>
        )}
        <div className="flex justify-between items-center basis-full">
          <h2 className="font-semibold text-sm md:text-lg lg:text-xl">
            Bienvenido, <span className="font-bold">{username}</span>
          </h2>
          <NavigationMenu
            id="navbar-nav"
            orientation="vertical"
            className="bg-primary text-accent px-4 py-2 rounded-md font-medium hidden xl :flex"
          >
            <NavigationMenuList id="navbar-nav-list" className="space-x-8">
              <NoDropDownItem title="Visitas" />
              <NoDropDownItem title="Campañas" />
              <NoDropDownItem title="Tratamientos" />
              <NavigationMenuItem id="navbar-rsrc" className="ms-12">
                <NavigationMenuTrigger className="font-medium text-md">
                  Recursos
                </NavigationMenuTrigger>
                <NavigationMenuContent id="rsrc-content">
                  <ul id="rsrc-list" className={MENUCONTENT_CLASS}>
                    {recursos.map((item) => (
                      <ListItem
                        key={item.rsrc}
                        title={item.title}
                        href={item.href}
                        id={`rsrc-${item.rsrc}`}
                      >
                        {item.descrip}
                      </ListItem>
                    ))}
                  </ul>
                </NavigationMenuContent>
              </NavigationMenuItem>
              {isAdmin && (
                <NavigationMenuItem>
                  <NavigationMenuTrigger className="font-medium text-md">
                    Mantenimiento
                  </NavigationMenuTrigger>
                  <NavigationMenuContent className={MENUCONTENT_CLASS} asChild>
                    <ul>
                      {config.map((item) => (
                        <ListItem key={item.rsrc} title={item.title}>
                          {item.descrip}
                        </ListItem>
                      ))}
                    </ul>
                  </NavigationMenuContent>
                </NavigationMenuItem>
              )}
            </NavigationMenuList>
          </NavigationMenu>
          <DropdownMenu>
            <DropdownMenuTrigger
              id="navbar-conf"
              asChild
              className="hidden lg:flex"
            >
              <Button variant={"outline"}>
                <Cog className="mr-2 h-4 w-4" />
                Configuración
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent className="hidden lg:block px-2 me-5">
              <DropdownMenuLabel className="text-sm font-semibold">
                {email}
              </DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuItem className="gap-1">
                <Pen className="h-4 w-4" />
                Editar Perfil
              </DropdownMenuItem>
              <DropdownMenuItem className="gap-1">
                <CircleHelp className="h-4 w-4" />
                Soporte
              </DropdownMenuItem>
              <DropdownMenuSeparator />
              <DropdownMenuItem className="gap-2 font-semibold">
                <Link
                  href={route("logout")}
                  method="post"
                  as="button"
                  className="flex gap-3 items-center"
                >
                  <LogOut className="h-4 w-4" />
                  Cerrar sesión
                </Link>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
        <DropdownMenu>
          <DropdownMenuTrigger asChild className="flex lg:hidden">
            <Button variant={"outline"}>
              <Menu className="h-4 w-4" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent className="block: lg:hidden px-2 me-5">
            <DropdownMenuLabel>Secciones</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem asChild>
              <Link href="" as="button">
                Visitas
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem>Campañas</DropdownMenuItem>
            <DropdownMenuItem>Tratamientos</DropdownMenuItem>
            <DropdownMenuSub>
              <DropdownMenuSubTrigger>Recursos</DropdownMenuSubTrigger>
              <DropdownMenuPortal>
                <DropdownMenuSubContent>
                  <DropdownMenuItem asChild>
                    <Link href="#">Personas</Link>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <Link href="#">Empresas</Link>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <Link href="#">Parcelas</Link>
                  </DropdownMenuItem>
                  <DropdownMenuItem asChild>
                    <Link href="#">Cultivos</Link>
                  </DropdownMenuItem>
                </DropdownMenuSubContent>
              </DropdownMenuPortal>
            </DropdownMenuSub>
            <DropdownMenuSeparator />
            <DropdownMenuLabel>Configuración</DropdownMenuLabel>
            <DropdownMenuLabel className="text-xs font-light pt-0">
              {email}
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem className="gap-1">
              <Pen />
              Editar Perfil
            </DropdownMenuItem>
            <DropdownMenuItem className="gap-1">
              <CircleHelp />
              Soporte
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem className="gap-2 font-semibold">
              <LogOut className="h-4 w-4" />
              Cerrar sesión
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
      <Separator />
    </nav>
  );
}

const ListItem = forwardRef<
  React.ElementRef<"a">,
  React.ComponentPropsWithoutRef<"a">
>(({ className, title, children, ...props }, ref) => {
  return (
    <li>
      <NavigationMenuLink
        className={cn(
          "block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground",
          className,
        )}
        asChild
      >
        <a ref={ref} {...props}>
          <div className="text-sm font-medium leading-none">{title}</div>
          <p className="line-clamp-2 text-sm leading-snug text-muted-foreground">
            {children}
          </p>
        </a>
      </NavigationMenuLink>
    </li>
  );
});
ListItem.displayName = "ListItem";

function NoDropDownItem({
  title,
  ref = "#",
  currentRoute,
}: {
  title: string;
  ref?: string;
  currentRoute?: string;
}) {
  return (
    <NavigationMenuItem className="transition hover:text-primary hover:bg-accent px-3 py-2 rounded-md cursor-pointer">
      <NavigationMenuLink active={currentRoute?.includes(ref)} asChild>
        <Link href={ref}>{title}</Link>
      </NavigationMenuLink>
    </NavigationMenuItem>
  );
}
