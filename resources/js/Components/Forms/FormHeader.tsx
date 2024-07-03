import { Badge, badgeVariants } from "@/Components/ui/badge";
import { Button, buttonVariants } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import { cn } from "@/lib/utils";
import { Actions, LayoutProps, Urls, UUID } from "@/types";
import { Link, router } from "@inertiajs/react";
import { ChevronLeft, Pen, Trash } from "lucide-react";
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
  title: string;
  className?: string;
  backUrl?: string;
  deleteUrl?: string;
}

export default function FormHeader({
  title,
  created_at,
  updated_at,
  urls,
  className,
  backUrl = "#",
  id,
}: Omit<LayoutProps, "mainTitle" | "pageTitle"> & Props) {
  function handleDelete() {
    console.debug("Enviando petición de eliminación");
    if (urls?.destroy) router.delete(urls.destroy);
  }

  return (
    <div className={cn("flex items-center gap-4", className)}>
      <Button variant={"outline"} size={"sm"} className="px-2 py-1" asChild>
        <Link as="button" id="back" href={backUrl}>
          <ChevronLeft className="h-4" />
        </Link>
      </Button>
      <Separator orientation="vertical" className="h-10" />
      <div className="flex gap-4">
        <div className="flex flex-col">
          <h1 className="font-extrabold text-5xl my-3">{title}</h1>
          <div className="flex gap-x-4 select-none">
            {urls && (
              <>
                <AlertDialog>
                  <AlertDialogTrigger
                    id={`delete-${id}`}
                    className={badgeVariants({ variant: "destructive" })}
                  >
                    <Trash className="size-4" />
                  </AlertDialogTrigger>
                  <AlertDialogContent id={`delete-${id}`}>
                    <AlertDialogHeader>
                      <AlertDialogTitle>
                        Confirmación para eliminar
                      </AlertDialogTitle>
                      <AlertDialogDescription>
                        Una vez eliminado, no podrás recuperar el registro.
                        ¿Estás seguro?
                      </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                      <AlertDialogCancel
                        className={buttonVariants({ variant: "outline" })}
                      >
                        No
                      </AlertDialogCancel>
                      <AlertDialogAction
                        className={buttonVariants({ variant: "destructive" })}
                        onClick={handleDelete}
                      >
                        Sí
                      </AlertDialogAction>
                    </AlertDialogFooter>
                  </AlertDialogContent>
                </AlertDialog>
                <Link
                  href={urls.edit || "#"}
                  id={`edit-${id}`}
                  className={badgeVariants({ variant: "default" })}
                  as="button"
                >
                  <Pen className="size-4" />
                </Link>
              </>
            )}
            {created_at && (
              <Badge variant={"outline"} className="">
                Creación: <span className="ml-3 font-thin">{created_at}</span>
              </Badge>
            )}

            {updated_at && (
              <Badge variant={"secondary"} className="">
                Últ. Ed: <span className="ml-3 font-thin">{updated_at}</span>
              </Badge>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
