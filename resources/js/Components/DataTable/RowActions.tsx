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

const LINK_CLASS =
  "transition flex items-center justify-start py-2 px-3 hover:bg-muted active:!border-0";
const ICON_CLASS = "mr-2 size-5";

interface Props {
  id: UUID;
  info: {
    nombre: string | string[];
    id: string;
  };
  url: string;
}

export default function RowActions({ id, info, url }: Props) {
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
