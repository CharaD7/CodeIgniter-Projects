<?php

class Reservations_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setReservedDate($post)
    {
        $this->db->insert('reserved_dates', ['date' => strtotime($post)]);
    }

    public function deleteReservedDate($id)
    {
        $this->db->limit(1);
        $this->db->where('id', $id);
        $this->db->delete('reserved_dates');
    }

    public function getCountReservedDates()
    {
        return $this->db->count_all_results('reserved_dates');
    }

    public function getAllReservedDates($limit = null, $page = null, $from_now = false)
    {
        if ($limit !== null && $page !== null) {
            $this->db->limit($limit, $page);
        }
        if ($from_now == true) {
            $this->db->where('date >=', strtotime("midnight", time()));
        }
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('reserved_dates');
        return $result->result_array();
    }

    public function getCountReservations()
    {
        return $this->db->count_all_results('reservations');
    }

    public function getAllReservations($limit = null, $page = null, $from_now = false)
    {
        if ($limit !== null && $page !== null) {
            $this->db->limit($limit, $page);
        }
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('reservations');
        return $result->result_array();
    }

    public function reservationDelete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('reservations');
    }

}
