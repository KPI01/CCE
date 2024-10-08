import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";
import { buttonVariants } from "@/Components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { CircleX, EllipsisVertical, Pencil, ScanSearch } from "lucide-react";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../ui/dialog";
import { Tooltip, TooltipContent, TooltipTrigger } from "../ui/tooltip";
import { cn } from "@/lib/utils";
import { Link, router } from "@inertiajs/react";

const ICON_CLASS = "mr-2 size-4";
const ICON_STROKE = 1.5;
const MENUITEM_CLASS = "cursor-pointer text-base w-full";

interface Props {
  display: string;
  simplified?: boolean;
  children?: React.ReactNode;
  url: string;
}

function handleDelete(url: string) {
  console.debug("Eliminando...", url.split("/").slice(-1)[0]);
  router.delete(url);
}

export default function Actions({
  simplified = false,
  display,
  children,
  url,
}: Props) {
  console.debug("url:", url);
  if (simplified && children) {
    return (
      <SimplifiedOptions display={display} children={children} url={url} />
    );
  }

  return <Menu display={display} resourceUrl={url} />;
}

interface MenuProps {
  display: string;
  resourceUrl: string;
}

function Menu({ display, resourceUrl }: MenuProps) {
  return (
    <AlertDialog>
      <DropdownMenu>
        <DropdownMenuTrigger
          className={buttonVariants({ variant: "ghost", size: "icon" })}
        >
          <EllipsisVertical className="size-5" strokeWidth={ICON_STROKE} />
        </DropdownMenuTrigger>
        <DropdownMenuContent align="center">
          <DropdownMenuLabel>Opciones</DropdownMenuLabel>
          <DropdownMenuItem className={MENUITEM_CLASS} asChild>
            <Link method="get" href={resourceUrl}>
              <ScanSearch className={ICON_CLASS} strokeWidth={ICON_STROKE} />
              <span>Detalles</span>
            </Link>
          </DropdownMenuItem>
          <DropdownMenuItem className={MENUITEM_CLASS} asChild>
            <Link method="get" href={`${resourceUrl}/edit`}>
              <Pencil className={ICON_CLASS} strokeWidth={ICON_STROKE} />
              <span>Editar</span>
            </Link>
          </DropdownMenuItem>
          <DropdownMenuItem
            className={cn(
              MENUITEM_CLASS,
              "focus:bg-destructive-foreground focus:text-accent",
            )}
            asChild
          >
            <AlertDialogTrigger>
              <CircleX className={ICON_CLASS} strokeWidth={ICON_STROKE} />
              <span className="">Eliminar</span>
            </AlertDialogTrigger>
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
      <AlertDialogContent>
        <AlertDialogHeader className="text-2xl font-bold">
          Confirma para eliminar
        </AlertDialogHeader>
        <AlertDialogDescription>
          Has seleccionado a {display} para eliminar. ¿Estás seguro?
          <div className="mt-2 text-xs">
            Esta acción eliminará totalmente el registro de la base de datos!
          </div>
        </AlertDialogDescription>
        <AlertDialogFooter>
          <AlertDialogCancel
            className={buttonVariants({ variant: "secondary" })}
          >
            No
          </AlertDialogCancel>
          <AlertDialogAction
            onClick={() => handleDelete(resourceUrl)}
            className={buttonVariants({ variant: "destructive" })}
          >
            Si
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  );
}

function SimplifiedOptions({
  display,
  children,
  url,
}: {
  display: string;
  children: React.ReactNode;
  url: string;
}) {
  return (
    <AlertDialog>
      <Dialog>
        <div className="flex w-full items-center justify-end gap-4">
          <Tooltip>
            <TooltipTrigger asChild>
              <DialogTrigger
                className={buttonVariants({
                  variant: "outline",
                  size: "sm",
                  className: "text-xs",
                })}
              >
                <Pencil
                  className={cn(ICON_CLASS, "m-0")}
                  strokeWidth={ICON_STROKE}
                />
                <span className="sr-only w-0">Editar</span>
              </DialogTrigger>
            </TooltipTrigger>
            <TooltipContent>Editar</TooltipContent>
          </Tooltip>
          <Tooltip>
            <TooltipTrigger asChild>
              <AlertDialogTrigger
                className={buttonVariants({
                  variant: "destructive",
                  size: "sm",
                  className: "w-fit text-xs",
                })}
              >
                <CircleX
                  className={cn(ICON_CLASS, "m-0")}
                  strokeWidth={ICON_STROKE}
                />
                <span className="sr-only">Eliminar</span>
              </AlertDialogTrigger>
            </TooltipTrigger>
            <TooltipContent>Eliminar</TooltipContent>
          </Tooltip>
        </div>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Editando</DialogTitle>
            <DialogDescription>
              Haz los cambios en los campos necesarios, y luego pulsa en guardar
              para enviarlos.
            </DialogDescription>
          </DialogHeader>
          {children}
        </DialogContent>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Confirmar Eliminación</AlertDialogTitle>
            <AlertDialogDescription className="flex flex-col">
              <span>
                Has seleccionado a: {display} para ser eliminado.{" "}
                <strong>¿Estas seguro?</strong>
              </span>
              <span className="mt-3 text-xs font-medium">
                Esta acción hará que se elimine el registro de la base de datos.
              </span>
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>No, cancelar</AlertDialogCancel>
            <AlertDialogAction
              className={buttonVariants({ variant: "destructive" })}
              onClick={() => handleDelete(url)}
            >
              Sí, estoy seguro
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </Dialog>
    </AlertDialog>
  );
}
