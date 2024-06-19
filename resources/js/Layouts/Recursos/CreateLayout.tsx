import { ReactNode } from 'react'
import { Head, Link } from '@inertiajs/react'
import MainLayout from '../MainLayout'
import { Button } from '@/Components/ui/button'
import { ChevronLeft } from 'lucide-react'
import { Separator } from '@/Components/ui/separator'

interface Props {
    children: ReactNode
    rsrc: string
}

export default function CreateLayout({ children, rsrc }: Props) {

    return (
        <MainLayout className='container'>
            <Head title={`Crear ${rsrc}`} />
            <div className='container transition w-full h-fit my-auto overflow-scroll'>
                <div className='flex items-center gap-x-4 my-12'>
                    <Button variant={'outline'} size={'sm'} className='px-2 py-1' asChild>
                        <Link href={route(`${rsrc}.index`)}>
                            <ChevronLeft className="h-4" />
                        </Link>
                    </Button>
                    <Separator orientation="vertical" className='h-10' />
                    <h1 className='font-bold text-3xl'>Creación de: {rsrc}</h1>
                </div>
                {children}
                <span className='block text-sm my-4 text-primary font-semibold'>
                    Los campos con (*) son obligatorios
                </span>
            </div>
        </MainLayout>
    )
}
