import { Button } from "@/Components/ui/button"
import { router, usePage } from "@inertiajs/react"

export default function Dashboard(logged: boolean)
{
    const { auth }: any = usePage().props
    console.log('var: logged', logged)
    console.log('var: session', )

    return (
        <>
        <h2>Dashboard</h2>

        <p>Has iniciado sesión como: {auth.user.name}</p>
        <Button className="max-w-fit" onClick={() => router.post(route('logout'))}>Logout</Button>
        </>
    )
}
