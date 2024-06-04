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
    DropdownMenuPortal
} from "@/Components/ui/dropdown-menu"
import {
    ExitIcon,
    GearIcon,
    Pencil1Icon,
    QuestionMarkCircledIcon,
    HamburgerMenuIcon
} from "@radix-ui/react-icons"
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from "@/Components/ui/navigation-menu"
import { Button } from "@/Components/ui/button"
import { Separator } from "@/Components/ui/separator"
import { cn } from "@/lib/utils"

import { forwardRef } from 'react'
import { Link } from "@inertiajs/react"
import { Label } from "@/Components/ui/label"

interface Resources {
    title: string,
    rsrc: string,
    href: string
}

const config: Resources[] = [
    {
        title: 'Usuarios',
        rsrc: 'user',
        href: '#'
    },
    {
        title: 'Roles',
        rsrc: 'roles',
        href: '#'
    }

]

const recursos: Resources[] = [
    {
        title: 'Personas',
        rsrc: 'persona',
        href: route('recurso.persona.index')
    },
    {
        title: 'Empresas',
        rsrc: 'empresa',
        href: route('recurso.empresa.index')
    },
    {
        title: 'Productos',
        rsrc: 'producto',
        href: '#'
    },
    {
        title: 'Cultivos',
        rsrc: 'cultivo',
        href: '#'
    },
]

function NoDropDownItem({ title, ref = '#', currentRoute }: { title: string, ref?: string, currentRoute?: string }) {
    return (
        <NavigationMenuItem className="transition hover:text-primary hover:bg-accent px-3  py-2 rounded-md">
            <Link href={ref}>
                <NavigationMenuLink active={currentRoute?.includes(ref)}>
                    {title}
                </NavigationMenuLink>
            </Link>
        </NavigationMenuItem>
    )
}

const ListItem = forwardRef<
    React.ElementRef<"a">,
    React.ComponentPropsWithoutRef<"a">
>(({ className, title, children, ...props }, ref) => {
    return (
        <li>
            <NavigationMenuLink asChild>
                <a
                    ref={ref}
                    className={cn(
                        "block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground",
                        className
                    )}
                    {...props}
                >
                    <div className="text-sm font-medium leading-none">{title}</div>
                </a>
            </NavigationMenuLink>
        </li>
    )
})
ListItem.displayName = "ListItem"

interface Props {
    username: string,
    email: string
    isAdmin: boolean
}

export default function NavBar({ username, email, isAdmin }: Props) {
    const currentRoute = route().current()?.toString()
    console.log(currentRoute)
    return (
        <nav role='navigation' className="basis-auto px-7 py-4 flex flex-col gap-3">
            <div className="flex justify-between items-center">
                <Link href={route('home')}>
                    <h2 className="font-semibold text-sm md:text-lg lg:text-xl">Bienvenido, <span className="font-bold">{username}</span></h2>
                </Link>
                <NavigationMenu orientation="vertical" className="bg-primary text-accent px-4 py-2 rounded-md font-medium">
                    <NavigationMenuList className="space-x-8">
                        <NoDropDownItem title="Visitas" />
                        <NoDropDownItem title="Campañas" />
                        <NoDropDownItem title="Tratamientos" />
                        <NavigationMenuItem>
                            <NavigationMenuTrigger>Recursos</NavigationMenuTrigger>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild className="hidden lg:flex">
                        <Button variant={"outline"}>
                            <GearIcon className="mr-2 h-4 w-4" />
                            Configuración
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent className="hidden lg:block px-2 me-5">
                        <DropdownMenuLabel>{username}</DropdownMenuLabel>
                        <DropdownMenuLabel className="text-xs font-light pt-0">{email}</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem className="gap-1">
                            <Pencil1Icon />
                            Editar Perfil
                        </DropdownMenuItem>
                        <DropdownMenuItem className="gap-1">
                            <QuestionMarkCircledIcon />
                            Soporte
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem className="gap-2 font-semibold">
                            <Link href={route('logout')} method="post" as="button" className="flex gap-3 items-center">
                                <ExitIcon />
                                Cerrar sesión
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild className="flex lg:hidden">
                        <Button variant={"outline"}>
                            <HamburgerMenuIcon />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent className="block: lg:hidden px-2 me-5">
                        <DropdownMenuLabel>Secciones</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem asChild>
                            <Link href=''>
                                Visitas
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem>Campañas</DropdownMenuItem>
                        <DropdownMenuItem>Tratamientos</DropdownMenuItem>
                        <DropdownMenuSub>
                            <DropdownMenuSubTrigger>
                                Recursos
                            </DropdownMenuSubTrigger>
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
                        <DropdownMenuLabel className="text-xs font-light pt-0">{email}</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem className="gap-1">
                            <Pencil1Icon />
                            Editar Perfil
                        </DropdownMenuItem>
                        <DropdownMenuItem className="gap-1">
                            <QuestionMarkCircledIcon />
                            Soporte
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem className="gap-2 font-semibold">
                            <ExitIcon />
                            Cerrar sesión
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
            <Separator />
        </nav>
    )
}
