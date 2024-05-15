import { Button } from '@/Components/ui/button'
import { Separator } from '@/Components/ui/separator'

import { Link } from '@inertiajs/react'

export default function NavBar({ uri, txt }: { uri: string | undefined, txt?: string }) {

    console.log('Props:', `text: ${txt}`, `uri: ${uri}`)

    return (
        <nav id='navbar' role='navigation' className="basis-auto px-7 py-4 flex flex-col">
            <div className="flex justify-between py-5">
                <h1 className="text-xl font-extrabold tracking-tight lg:text-4xl">
                    <span className="text-primary">C</span>uaderno de <span className="text-primary">C</span>
                    ampo <span className="text-primary">E</span>lectrónico
                </h1>
                {
                    uri !== undefined &&
                    <Button variant={'outline'} asChild>
                        <Link href={route(uri)}>{txt}</Link>
                    </Button>
                }

            </div>
            <Separator className='bg-primary/25' />
        </nav>
    )
}
