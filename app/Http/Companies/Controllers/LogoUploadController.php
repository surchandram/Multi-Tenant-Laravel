<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\Repositories\CompanyRepository;

class LogoUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Company $company, CompanyRepository $companyRepository)
    {
        $this->validate($request, [
            'logo' => [
                'required',
                'image',
                'dimensions:min_width=1024,min_height=768',
            ],
        ]);

        try {
            $companyRepository->uploadLogo($company, $request->file('logo'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'logo' => $e->getMessage(),
            ]);
        }

        return redirect()->back()->withSuccess(__('Logo uploaded successfully.'));
    }
}
