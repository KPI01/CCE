import { Badge, badgeVariants } from "@/Components/ui/badge";
import { buttonVariants } from "@/Components/ui/button";
import { cn } from "@/lib/utils";
import { LayoutProps } from "@/types";
import { Link, router } from "@inertiajs/react";
import { Pen, Trash } from "lucide-react";
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
import { formatDate } from "date-fns";
import { es } from "date-fns/locale";

interface Props
  extends Omit<
    LayoutProps,
    "mainTitle" | "pageTitle" | "created_at" | "updated_at"
  > {
  title: string;
  className?: string;
  created_at: Date | null;
  updated_at: Date | null;
  showActions?: boolean;
}

const DATE_FORMAT = "eee, dd/MM/yyyy - HH:mm";

export default function FormHeader({
  title,
  created_at,
  updated_at,
  url,
  className,
  id,
  showActions = true,
}: Props) {
  function handleDelete() {
    router.delete(url);
  }

  return (
    <div className={cn("flex items-center gap-4", className)}>
      <div className="flex gap-4">
        <div className="flex flex-col">
          <h1 id="main-title" className="my-3 text-5xl font-extrabold">
            {title}
          </h1>
          <div className="flex select-none gap-x-4">
            {showActions && (
              <>
                <AlertDialog>
                  <AlertDialogTrigger
                    id="badge-destroy"
                    className={badgeVariants({ variant: "destructive" })}
                  >
                    <Trash className="size-4" />
                  </AlertDialogTrigger>
                  <AlertDialogContent id="delete-dialog">
                    <AlertDialogHeader id="alert-title">
                      <AlertDialogTitle>
                        Confirmación para eliminar
                      </AlertDialogTitle>
                      <AlertDialogDescription>
                        Una vez eliminado, no podrás recuperar el registro.
                        ¿Estás seguro?
                      </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter id="alert-footer">
                      <AlertDialogCancel
                        id="delete-cancel"
                        className={buttonVariants({ variant: "outline" })}
                      >
                        No
                      </AlertDialogCancel>
                      <AlertDialogAction
                        id="delete-confirm"
                        className={buttonVariants({ variant: "destructive" })}
                        onClick={handleDelete}
                      >
                        Sí
                      </AlertDialogAction>
                    </AlertDialogFooter>
                  </AlertDialogContent>
                </AlertDialog>
                <Link
                  href={`${url}/edit` || "#"}
                  id="badge-edit"
                  className={badgeVariants({ variant: "default" })}
                  as="button"
                >
                  <Pen className="size-4" />
                </Link>
              </>
            )}
            {created_at && (
              <Badge variant={"outline"} id="badge-createdAt">
                Creación:{" "}
                <span className="ml-3 font-thin">
                  {formatDate(created_at, DATE_FORMAT, { locale: es })}
                </span>
              </Badge>
            )}
            {updated_at && (
              <Badge variant={"secondary"} id="badge-updatedAt">
                Últ. Ed:{" "}
                <span className="ml-3 font-thin">
                  {formatDate(updated_at, DATE_FORMAT, { locale: es })}
                </span>
              </Badge>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
