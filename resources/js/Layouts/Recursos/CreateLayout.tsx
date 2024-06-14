import { ReactNode } from 'react'
import { Head } from '@inertiajs/react'
import MainLayout from '../MainLayout'

interface Props {
    children: ReactNode
    rsrc: string
}

export default function CreateLayout({ children, rsrc }: Props) {

    return (
        <MainLayout className='container'>
            <Head title={`Crear ${rsrc}`} />
            <div className='container transition w-full h-fit my-auto overflow-scroll'>
                <h1 className='font-bold text-3xl mb-12'>Creación de: {rsrc}</h1>
                {children}
                <span className='block text-sm my-4 text-primary font-semibold'>
                    Los campos con (*) son obligatorios
                </span>
            </div>
        </MainLayout>
    )
}
