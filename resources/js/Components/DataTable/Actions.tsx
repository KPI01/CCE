import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";
import { Button, buttonVariants } from "@/Components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import { CircleX, EllipsisVertical, Pencil, ScanSearch } from "lucide-react";

const ICON_CLASS = "mr-2 size-5";
const ICON_STROKE = 1.5;
const MENUITEM_CLASS = "cursor-pointer text-base";

interface Props {
  display: string;
  simplified?: boolean;
}

export default function Actions({ simplified = false, display }: Props) {
  if (simplified) {
    return <SimplfiedOptions />;
  }

  return <Menu display={display} />;
}

function Menu({ display }: { display: string }) {
  const redirectEdit = () => {};

  const handleDelete = () => {};

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
          <DropdownMenuItem className={MENUITEM_CLASS}>
            <ScanSearch className={ICON_CLASS} strokeWidth={ICON_STROKE} />
            Detalles
          </DropdownMenuItem>
          <DropdownMenuItem className={MENUITEM_CLASS} onClick={redirectEdit}>
            <Pencil className={ICON_CLASS} strokeWidth={ICON_STROKE} />
            Editar
          </DropdownMenuItem>
          <DropdownMenuItem className={MENUITEM_CLASS}>
            <AlertDialogTrigger className="flex items-center">
              <CircleX className={ICON_CLASS} strokeWidth={ICON_STROKE} />
              Eliminar
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
          <AlertDialogCancel className={buttonVariants({ variant: "default" })}>
            No
          </AlertDialogCancel>
          <AlertDialogAction
            onClick={handleDelete}
            className={buttonVariants({ variant: "destructive" })}
          >
            Si
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  );
}

function SimplfiedOptions() {
  return (
    <div className="flex w-full items-center justify-end gap-4">
      <Button size={"sm"} variant={"outline"}>
        <Pencil className={ICON_CLASS} strokeWidth={ICON_STROKE} />
        Editar
      </Button>
      <Button size={"sm"} variant={"outline"}>
        <CircleX className={ICON_CLASS} strokeWidth={ICON_STROKE} />
        Eliminar
      </Button>
    </div>
  );
}
