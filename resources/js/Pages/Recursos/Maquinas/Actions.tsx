import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { Button } from "@/Components/ui/button";
import { Link, router } from "@inertiajs/react";
import { File, MoreHorizontal, Pen, Trash } from "lucide-react";
import { Maquina } from "@/types";
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

export default function Actions({ item }: { item: Maquina }) {
  function handleDelete(url: string) {
    router.delete(url);
  }

  if (item.urls)
    return (
      <AlertDialog>
        <DropdownMenu>
          <DropdownMenuTrigger asChild id={`action-menu-${item.id}`}>
            <Button variant="ghost" className="h-8 w-8 p-0">
              <span className="sr-only">Menú</span>
              <MoreHorizontal className="h-4 w-4" />
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem asChild className="w-full cursor-pointer">
              <Link href={item.urls?.show} id={`action-show-${item.id}`}>
                <File className="mr-2 h-4 w-4" />
                Ver detalles
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem asChild className="w-full cursor-pointer">
              <Link href={item.urls?.edit} id={`action-edit-${item.id}`}>
                <Pen className="mr-2 h-4 w-4" />
                Editar
              </Link>
            </DropdownMenuItem>
            <DropdownMenuItem
              asChild
              className="w-full cursor-pointer hover:!text-destructive"
              id={`action-delete-${item.id}`}
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
                <span className="font-bold">{item.nombre}</span> <br />
                <span className="font-bold">Matrícula: {item.matricula}</span>
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
