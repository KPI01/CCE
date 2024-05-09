import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/Components/ui/alert-dialog"
import { Button } from "../ui/button"

interface Props {
    canOpen: boolean
    open: boolean
    callback?: (val: boolean) => void
}

export default function ConfirmEmailDialog({
    canOpen, open, callback
}: Props) {

    console.log('<ConfirmEmailDialog>', 'var: canOpen', canOpen)
    console.log('<ConfirmEmailDialog>', 'var: open', open)

    if (canOpen) {
        return (
            <AlertDialog open={open}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Confirmación de correo</AlertDialogTitle>
                        <AlertDialogDescription>
                            Se ha enviado un link a tu correo con el cual podrás verificar tu cuenta y comenzar a utilizar la aplicación.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <Button asChild onClick={() => callback?.(false)}>
                            <AlertDialogAction>Volver</AlertDialogAction>
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

        )
    }
}