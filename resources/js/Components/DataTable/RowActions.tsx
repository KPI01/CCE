import { Link, router } from "@inertiajs/react";
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
} from "../ui/alert-dialog";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "../ui/dropdown-menu";
import { Button, buttonVariants } from "../ui/button";
import { Ellipsis, FileText, PenLine, Trash } from "lucide-react";
import { DropdownMenuItem } from "@radix-ui/react-dropdown-menu";
import { UUID } from "@/types";
import { useState } from "react";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../ui/dialog";
import { Input } from "../ui/input";
import { Label } from "../ui/label";
import { DeleteIcon, SaveUpdateIcon } from "@/Pages/Recursos/utils";
import { useToast } from "../ui/use-toast";

const LINK_CLASS =
  "transition flex items-center justify-start py-2 px-3 hover:bg-muted active:!border-0";
const ICON_CLASS = "mr-2 size-5";

interface Props {
  id: UUID | number;
  info: {
    nombre: string | string[];
    id?: string;
    value?: unknown;
  };
  url: string;
}

export function RowActions({ id, info = { nombre: "recurso" }, url }: Props) {
  function handleDelete() {
    router.delete(url);
  }

  return (
    <AlertDialog>
      <DropdownMenu>
        <DropdownMenuTrigger id={`actions-${id}`} asChild>
          <Button variant={"ghost"} className="h-8 w-8 p-0">
            <span className="sr-only">Menú</span>
            <Ellipsis className="size-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="start">
          <DropdownMenuItem id={`action-show-${id}`} asChild>
            <Link href={url} method="get" className={LINK_CLASS}>
              <FileText className={ICON_CLASS} />
              Ver detalles
            </Link>
          </DropdownMenuItem>
          <DropdownMenuItem id={`action-edit-${id}`} asChild>
            <Link href={`${url}/edit`} method="get" className={LINK_CLASS}>
              <PenLine className={ICON_CLASS} />
              Editar
            </Link>
          </DropdownMenuItem>
          <DropdownMenuItem
            id={`action-destroy-${id}`}
            className="hover:!text-destructive"
            asChild
          >
            <AlertDialogTrigger className={LINK_CLASS + " w-full"}>
              <Trash className={ICON_CLASS} />
              Eliminar
            </AlertDialogTrigger>
          </DropdownMenuItem>
        </DropdownMenuContent>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Solicitud de confirmación</AlertDialogTitle>
            <AlertDialogDescription className="font-bold">
              <span>Datos del recurso a eliminar:</span>{" "}
              <span>
                {typeof info.nombre === "object" && info.nombre.join(" ")}
                {typeof info.nombre === "string" && info.nombre} ({info.id})
              </span>
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>No quiero eliminar</AlertDialogCancel>
            <AlertDialogAction
              className={buttonVariants({ variant: "destructive" })}
              onClick={handleDelete}
            >
              Si quiero eliminar
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </DropdownMenu>
    </AlertDialog>
  );
}

export function RowActionsLiveEdit({ id, info, url }: Props) {
  const { toast } = useToast();
  const current = info.nombre as string;
  const [value, setValue] = useState(current);

  console.log("url:", url);

  function handleDelete() {
    router.delete(url);
  }
  function handleUpdate() {
    if (current === value) {
      toast({
        title: "No se ha realizado ningún cambio",
        description: `El nombre del recurso es igual al actual`,
        variant: "warning",
      });
      return;
    }
    router.put(url, { nombre: value });
  }
  return (
    <Dialog>
      <DropdownMenu>
        <DialogTrigger asChild>
          <DropdownMenuTrigger id={`actions-${id}`} asChild>
            <Button variant={"ghost"} className="h-8 w-8">
              <span className="sr-only">Menú</span>
              <Ellipsis className="size-4" />
            </Button>
          </DropdownMenuTrigger>
        </DialogTrigger>
      </DropdownMenu>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{info.nombre ?? "Opciones"}</DialogTitle>
          <DialogDescription>
            Aquí podrás editar o eliminar el registro.
          </DialogDescription>
        </DialogHeader>
        <div className="flex items-center">
          <Label className="w-[15ch]">Nuevo valor:</Label>
          <Input
            placeholder={current}
            onChange={(e) => setValue(e.target.value)}
          />
        </div>
        <div className="align-center mt-4 flex justify-end gap-4">
          <Button variant={"destructive"} size={"sm"} onClick={handleDelete}>
            <DeleteIcon />
            Eliminar
          </Button>
          <Button size={"sm"} onClick={handleUpdate}>
            <SaveUpdateIcon />
            Actualizar
          </Button>
        </div>
      </DialogContent>
    </Dialog>
  );
}
