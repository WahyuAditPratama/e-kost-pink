package com.app.kostpink.fragment;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;

import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.adapter.TagihanAdapter;
import com.app.kostpink.databinding.FragmentHistoriBinding;
import com.app.kostpink.model.FetchTagihanResponse;
import com.app.kostpink.model.Tagihan;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class HistoriFragment extends Fragment {

    FragmentHistoriBinding binding;
    private List<Tagihan> tagihanList = new ArrayList<>();
    TagihanAdapter tagihanAdapter;
    String id_customer;
    SharedPrefManager sharedPrefManager;

    Calendar calendar1 = Calendar.getInstance();
    SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd", new Locale("id", "id"));
    String tanggal = sdf1.format(calendar1.getTime());

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentHistoriBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        sharedPrefManager = new SharedPrefManager(getActivity());
        id_customer = sharedPrefManager.getCustomer().getId_customer();

        tagihanAdapter = new TagihanAdapter(getActivity(), tagihanList);
        binding.rv1.setLayoutManager(new LinearLayoutManager(getContext()));
        binding.rv1.setAdapter(tagihanAdapter);

        binding.sfWaiting.setOnRefreshListener(this::getData);

        getData();
        return view;
    }

    void getData() {
        binding.sfWaiting.setRefreshing(true);

        Call<FetchTagihanResponse> call = ApiClient.getInstance().getApi().fetchTagihanHistori(id_customer);
        call.enqueue(new Callback<FetchTagihanResponse>() {
            @Override
            public void onResponse(Call<FetchTagihanResponse> call, Response<FetchTagihanResponse> response) {
                binding.sfWaiting.setRefreshing(false);

                if (response.isSuccessful() && response.body() != null) {
                    if (response.body().getStatus()) {
                        tagihanList = response.body().getData();
                        tagihanAdapter.updateList(tagihanList);

                        binding.rv1.setVisibility(View.VISIBLE);
                        binding.tvNull.setVisibility(View.GONE);
                    } else {
                        binding.rv1.setVisibility(View.GONE);
                        binding.tvNull.setVisibility(View.VISIBLE);
                        Toast.makeText(getActivity(), response.body().getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    binding.rv1.setVisibility(View.GONE);
                    binding.tvNull.setVisibility(View.VISIBLE);
                    Toast.makeText(getActivity(), "Gagal mendapatkan data", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchTagihanResponse> call, Throwable t) {
                binding.sfWaiting.setRefreshing(false);
                binding.rv1.setVisibility(View.GONE);
                binding.tvNull.setVisibility(View.VISIBLE);
                Toast.makeText(getActivity(), t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}
