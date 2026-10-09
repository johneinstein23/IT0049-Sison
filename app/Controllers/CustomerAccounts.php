<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAccounts extends BaseController
{
    private CustomerModel $customers;

    public function __construct()
    {
        $this->customers = new CustomerModel();
    }

    public function index()
    {
        return view('customers/index', [
            'title'     => 'Customer Accounts',
            'customers' => $this->customers->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function createForm()
    {
        return view('customers/form', [
            'title'    => 'Add Customer',
            'customer' => [],
            'action'   => site_url('customers'),
            'isEdit'   => false,
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->customers->insert([
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Customer added successfully.');
    }

    public function edit(int $id)
    {
        $customer = $this->customers->find($id);
        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/form', [
            'title'    => 'Edit Customer',
            'customer' => $customer,
            'action'   => site_url('customers/' . $id),
            'isEdit'   => true,
        ]);
    }

    public function update(int $id)
    {
        if ($this->customers->find($id) === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->customers->update($id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Customer updated successfully.');
    }
}
