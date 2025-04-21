<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

class RoleMiddleware
{

        public function handle(Request $request, Closure $next, ...$roles)
        {
            if (!Auth::check()) {
                Log::error("User belum login!");
                return redirect()->route('login')->withErrors('Anda belum login!');
            }

            $userRole = Auth::user()->role; // Ambil role user

            Log::info("User role: $userRole, Expected roles: " . json_encode($roles));

            // ✅ FIX: Izinkan admin masuk meskipun hanya 'kasir' yang diperbolehkan
            if ($userRole === 'admin' || in_array($userRole, $roles)) {
                return $next($request);
            }

            Log::warning("Akses ditolak untuk role: $userRole, hanya boleh untuk: " . json_encode($roles));

            return response()->json([
                'error' => 'Akses ditolak!',
                'user_role' => $userRole,
                'expected_roles' => $roles,
            ], 403);
        }
    }
