export type AdminMenuItem = {
  id: number
  label: string
  route_name?: string | null
  url?: string | null
  icon_type: 'lucide' | 'dalle' | 'none'
  icon_name?: string | null
  icon_path?: string | null
}
