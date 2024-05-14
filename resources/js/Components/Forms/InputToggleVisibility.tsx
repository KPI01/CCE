import { useState } from "react";
import { Link } from "@inertiajs/react";
import {
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage
} from "@/Components/ui/form";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { EyeOpenIcon, EyeClosedIcon } from "@radix-ui/react-icons"

export default function InputToggleVisibility({...props}) {

    const currentRoute = route().current()

    let [visibility, setVisibility] = useState(false)

    return (
        <FormField
            control={props.control}
            name={props.name}
            render={({ field }) => (
                <FormItem>
                    <FormLabel htmlFor={props.name}>{props.label}</FormLabel>
                    <FormControl>
                        <div className="flex w-full items-center space-x-2">
                            <Input
                            id={`${props.name}`}
                            autoComplete="off"
                                type={visibility ? 'text' : 'password'}
                                {...field} />
                            <Button id={`show-${props.name}`} type="button" variant={'outline'} onClick={() => setVisibility(!visibility)}>
                                {visibility
                                    ? <EyeOpenIcon />
                                    : <EyeClosedIcon />
                                }
                            </Button>
                        </div>
                    </FormControl>
                    <FormMessage className="max-w-sm" />
                    {
                        currentRoute === 'form.login' &&
                        <Button asChild variant={'link'}>
                            <Link href={route('form.reset-pass')}>¿Clave olvidada?</Link>
                        </Button>
                    }
                </FormItem>
            )} />
    )
}
