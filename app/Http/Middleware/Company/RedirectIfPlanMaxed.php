<?php

namespace SAAS\Http\Middleware\Company;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Features\Models\Feature;

class RedirectIfPlanMaxed
{
    protected $feature;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $company = null, $feature = null)
    {
        $this->feature = $feature;

        $value = $company ? $company : $request->tenant();

        $company = $this->resolveCompany($value);

        if (! $company) {
            return redirect()->back()->withInfo(
                __('Company\'s does not have a valid subscription yet to access feature.')
            );
        }

        $model = Arr::get(config('saas.features.models'), $feature);

        // handle if company does not have a plan
        if (! $company->plan) {
            $feature = $this->getFeature($feature);

            $this->feature = $feature->name;

            if (! $model && ! class_exists($model)) {
                return $this->handleRedirect();
            }

            $count = $this->getModelCount($model);

            $maxed = $this->checkIfMaxed($count, $feature->trial_limit);

            if ($maxed) {
                return $this->handleRedirect();
            }

            return $next($request);
        }

        if (! ($planFeature = $company->plan->feature($feature))) {
            $featureModel = $this->getFeature($feature);
        }

        $this->feature = ($planFeature instanceof Model) ? $planFeature->feature->name : $featureModel->name;

        if ($this->checkIfMaxed($this->getModelCount($model), ($planFeature ? $planFeature->limit : $featureModel->trial_limit))) {
            return $this->handleRedirect();
        }

        return $next($request);
    }

    /**
     * Message to return if plan feature maxed.
     *
     * @return string
     **/
    public function maxedMessage()
    {
        return __(
            'Sorry, you have reached the limit for your plan, please upgrade to continue using ":feature"', [
                'feature' => $this->feature,
            ]);
    }

    /**
     * Handle redirection.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\RedirectResponse
     **/
    public function handleRedirect()
    {
        return request()->expectsJson() ? response()->json([
            'message' => $this->maxedMessage(),
        ], 403) : redirect()->back()->withInput()->withInfo($this->maxedMessage());
    }

    /**
     * Get the number of slots used for feature model.
     *
     * @param  string  $model The model class
     * @return int
     **/
    public function getModelCount(string $model)
    {
        return $model::count();
    }

    /**
     * Get the model instance of given feature.
     *
     * @param  string  $feature Value of feature to search
     * @return \Illuminate\Database\Eloquent\Model|null
     **/
    public function getFeature(string $feature = null)
    {
        return Feature::where('key', $feature)->active()->first();
    }

    /**
     * Determine if feature is maxed and choose to redirect.
     *
     * @param  int  $count The total slots used for feature
     * @param  int  $limit The maximum number of slots allowed in feature
     * @return bool
     **/
    public function checkIfMaxed(int $count, int $limit)
    {
        return $count >= $limit;
    }

    /**
     * Resolve and get the company instance from passed value.
     *
     * @param  int|string|\Illuminate\Database\Eloquent\Model  $value The id, domain or company instance
     * @return \Illuminate\Database\Eloquent\Model|null
     **/
    public function resolveCompany($value)
    {
        $company = null;

        if (is_numeric($value)) {
            $company = Company::find($value);
        } elseif (is_string($value)) {
            $company = Company::whereDomain($value)->first();
        } elseif ($value instanceof Company) {
            $company = $value;
        }

        return $company;
    }
}
