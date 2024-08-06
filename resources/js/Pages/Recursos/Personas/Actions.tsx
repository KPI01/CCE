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
import RowActions from "@/Components/Table/RowActions";

export default function Actions({ data }: { data: Persona }) {
  return (
    <RowActions
      id={data.id}
      urls={data.urls}
      info={{
        id: data.id_nac,
        nombre: [data.nombres, data.apellidos],
      }}
    />
  );
}
