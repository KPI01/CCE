import NavBar from '@/Components/NavBar'

import { ReactNode, StrictMode } from 'react'
import { usePage } from '@inertiajs/react'
import { cn } from '@/lib/utils'

interface Props {
    children: ReactNode
    className?: string
}

export default function MainLayout({ children, className }: Props) {
    const { auth, session }: any = usePage().props
    const isAdmin: boolean = auth.user.role.name === 'Admin'
    // console.log(auth)
    // console.log(isAdmin)
    console.log(session)

    return (
        <StrictMode>
        <NavBar username={auth.user.name} email={auth.user.email} isAdmin={isAdmin}/>
        <main className={cn('px-16 py-6 h-full overflow-auto', className)}>
            {children}
        </main>
        </StrictMode>
    )
}
