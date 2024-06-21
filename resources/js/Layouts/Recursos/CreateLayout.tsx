import { Head, Link } from '@inertiajs/react'
import MainLayout from '../MainLayout'
import { Button } from '@/Components/ui/button'
import { ChevronLeft } from 'lucide-react'
import { Separator } from '@/Components/ui/separator'
import { LayoutProps } from '@/types'
import FormHeader from './FormHeader'

export default function CreateLayout({
    children,
    recurso,
    pageTitle,
    mainTitle
}: LayoutProps) {

    return (
        <MainLayout className='container'>
            <Head title={pageTitle} />
            <FormHeader title={pageTitle} recurso={recurso} />
                {children}
                <span className='block text-sm my-4 text-primary font-semibold'>
                    Los campos con (*) son obligatorios
                </span>
        </MainLayout>
    )
}
