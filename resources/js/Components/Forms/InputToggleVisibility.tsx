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

export default function InputToggleVisibility({
    ...props
}) {

    const currentRoute = route().current()

    let [visibility, setVisibility] = useState(false)

    return (
        <FormField
            control={props.control}
            name={props.name}
            render={({ field }) => (
                <FormItem>
                    <FormLabel>{props.label}</FormLabel>
                    <FormControl>
                        <div className="flex w-full items-center space-x-2">
                            <Input
                                type={visibility ? 'text' : 'password'}
                                {...field} />
                            <Button type="button" variant={'outline'} onClick={() => setVisibility(!visibility)}>
                                {visibility
                                    ? <EyeOpenIcon />
                                    : <EyeClosedIcon />
                                }
                            </Button>
                        </div>
                    </FormControl>
                    {
                        currentRoute === 'login' &&
                        <Button asChild variant={'link'}>
                            <Link href={route('reset_clave')}>¿Clave olvidada?</Link>
                        </Button>
                    }
                    <FormMessage />
                </FormItem>
            )} />
    )
}