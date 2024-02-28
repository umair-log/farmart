<?php

namespace Botble\Location\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Location\Forms\StateForm;
use Botble\Location\Http\Requests\StateRequest;
use Botble\Location\Http\Resources\StateResource;
use Botble\Location\Models\State;
use Botble\Location\Repositories\Interfaces\StateInterface;
use Botble\Location\Tables\StateTable;
use Exception;
use Illuminate\Http\Request;

class StateController extends BaseController
{
    public function __construct(protected StateInterface $stateRepository)
    {
    }

    public function index(StateTable $table)
    {
        PageTitle::setTitle(trans('plugins/location::state.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/location::state.create'));

        return $formBuilder->create(StateForm::class)->renderForm();
    }

    public function store(StateRequest $request, BaseHttpResponse $response)
    {
        $state = $this->stateRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));

        return $response
            ->setPreviousUrl(route('state.index'))
            ->setNextUrl(route('state.edit', $state->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(State $state, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $state->name]));

        return $formBuilder->create(StateForm::class, ['model' => $state])->renderForm();
    }

    public function update(State $state, StateRequest $request, BaseHttpResponse $response)
    {
        $state->fill($request->input());

        $this->stateRepository->createOrUpdate($state);

        event(new UpdatedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));

        return $response
            ->setPreviousUrl(route('state.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(State $state, Request $request, BaseHttpResponse $response)
    {
        try {
            $this->stateRepository->delete($state);

            event(new DeletedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $state = $this->stateRepository->findOrFail($id);
            $this->stateRepository->delete($state);
            event(new DeletedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function getList(Request $request, BaseHttpResponse $response)
    {
        $keyword = BaseHelper::stringify($request->input('q'));

        if (! $keyword) {
            return $response->setData([]);
        }

        $data = $this->stateRepository->advancedGet([
            'condition' => [
                ['states.name', 'LIKE', '%' . $keyword . '%'],
            ],
            'select' => ['states.id', 'states.name'],
            'take' => 10,
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ]);

        $data->prepend(new State(['id' => 0, 'name' => trans('plugins/location::city.select_state')]));

        return $response->setData(StateResource::collection($data));
    }

    public function ajaxGetStates(Request $request, BaseHttpResponse $response)
    {
        $params = [
            'select' => ['states.id', 'states.name'],
            'condition' => [
                'states.status' => BaseStatusEnum::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ];

        if ($request->input('country_id') && $request->input('country_id') != 'null') {
            $params['condition']['states.country_id'] = $request->input('country_id');
        }

        $data = $this->stateRepository->advancedGet($params);

        $data->prepend(new State(['id' => 0, 'name' => trans('plugins/location::city.select_state')]));

        return $response->setData(StateResource::collection($data));
    }
}
