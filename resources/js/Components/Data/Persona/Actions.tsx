import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { Button } from "@/Components/ui/button";
import { Link, router } from "@inertiajs/react";
import { File, MoreHorizontal, Pen, Trash } from "lucide-react";
import { Persona } from "@/types";
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

interface Props {
  item: Persona;
}

export default function Actions({ item }: Props) {
  function handleDelete(url: string) {
    console.log(url);

    router.visit(url, {
      method: "delete",
      onSuccess: () => {
        console.log("Eliminado");
      },
    });
  }

  if (item.urls)
    return (
      <AlertDialog>
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" className="h-8 w-8 p-0">
              <span className="sr-only">Menú</span>
              <MoreHorizontal className="h-4 w-4" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent forceMount align="end">
            <DropdownMenuItem asChild className="cursor-pointer w-full">
              <Link href={item.urls?.show}>
                <File className="mr-2 h-4 w-4" />
                Ver detalles
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem asChild className="cursor-pointer w-full">
              <Link href={item.urls?.edit} method="get" as="button">
                <Pen className="mr-2 h-4 w-4" />
                Editar
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem
              asChild
              className="cursor-pointer w-full hover:!bg-destructive/25"
            >
              <AlertDialogTrigger>
                <Trash className="mr-2 h-4 w-4" />
                Eliminar
              </AlertDialogTrigger>
            </DropdownMenuItem>
          </DropdownMenuContent>
          <AlertDialogContent>
            <AlertDialogHeader>
              <AlertDialogTitle>Confirmación para eliminar</AlertDialogTitle>
              <AlertDialogDescription>
                Se procederá a eliminar a... <br />
                <span className="font-bold">
                  {item.nombres} {item.apellidos}
                </span>{" "}
                <br />
                <span className="font-bold">
                  {item.tipo_id_nac}: {item.id_nac}
                </span>
              </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
              <AlertDialogCancel>Cancelar</AlertDialogCancel>
              <Button
                variant={"destructive"}
                asChild
                onClick={() => {
                  if (item.urls) handleDelete(item.urls?.destroy);
                }}
              >
                <AlertDialogAction>Eliminar</AlertDialogAction>
              </Button>
            </AlertDialogFooter>
          </AlertDialogContent>
        </DropdownMenu>
      </AlertDialog>
    );
}
